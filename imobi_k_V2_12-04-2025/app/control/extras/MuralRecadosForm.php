<?php

// como foi feito em : https://www.youtube.com/watch?v=KyXqGPgIxiU&t=74s

class MuralRecadosForm extends TPage
{
    
    private static $database = 'imobi_producao';
    
    public function __construct($param)
    {
        parent::__construct();
        
        $html = new THtmlRenderer('app/resources/mural_recados_form.html');
        $html->disableHtmlConversion(); // desabilita a impressão de caracteres html
        
        //$recado = new THtmlEditor('recado');
        $recado = new TText('recado');
        $recado->setSize( '100%', 150);
        // $recado->setOption('placeholder', 'Escreva aqui...');
        $recado->class = 'form-control';
        
        $dtpublicacao = new TDate('dtpublicacao');
        $dtpublicacao->class = 'form-control';
        $dtpublicacao->setMask('dd/mm/yyyy');
        
        
        // recados
        // define criteria properties
        $criteria = new TCriteria; 
        $criteria->setProperty('order', 'dtpublicacao desc, idmural desc');
        $criteria->setProperty('limit' , 16);
        $criteria->add(new TFilter('dtpublicacao', '<=', date('Y-m-d')));
        $repository = new TRepository('Mural');
        TTransaction::open(self::$database); // open a transaction
        $posts = $repository->load($criteria);
        TTransaction::close();
        
        
        if ($posts)
        {
            foreach($posts AS $row => $post)
            {

                if($row == 0)
                {
                    $dtitulo = $post->titulo;
                    $dby = $post->fk_idsystemuser->name . ' - ' . TDate::date2br($post->dtpublicacao);
                    $dpost = ((strlen($post->post) > 500) AND ($post->idmural != 1)) ? substr($post->post, 0, 500). '... ' : $post->post;
                    $dbutton = ((strlen($post->post) > 500) AND ($post->idmural != 1)) ? '<a class="btn btn-primary btn-lg" href="#" role="button">Ler Mais »</a>' : '';
                    $dexcluir = $post->idsystemuser == TSession::getValue('userid') ? '<a class="btn btn-outline-primary btn-sm" href="#" role="button">Excluir</a>' : '';

                }
                else
                {
                    $replace[] = array('titulo'   => (string) strtoupper($post->titulo),
                                       'by'       => $post->fk_idsystemuser->name . ' - ' . TDate::date2br($post->dtpublicacao),
                                       'post'     => ((strlen($post->post) > 300) AND ($post->idmural != 1)) ? substr($post->post, 0, 300). '...' : $post->post,
                                       'button'   => ((strlen($post->post) > 300) AND ($post->idmural != 1)) ? '<a class="btn btn-secondary" href="#" role="button">Ver Detalhes »</a>' : '',
                                       'excluir'  => $post->idsystemuser == TSession::getValue('userid') ? '<a class="btn btn-outline-secondary btn-sm" href="#" role="button">Excluir</a>' : ''
                                       );                    
                }

            }
        }
        
        $html->enableSection('main', [ 'recado'       => $recado,
                                       'dtpublicacao' => $dtpublicacao,
                                       'dtitulo'      => $dtitulo,
                                       'dby'          => $dby,
                                       'dpost'        => $dpost,
                                       'dbutton'      => $dbutton,
                                       'dexcluir'     => $dexcluir
                                     ]);
        
        $html->enableSection('mural', $replace, TRUE);   
        
        parent::add($html);
    }
    
    public static function onSave( $param = null)
    {
        
        try
        {
            
            if( empty( $param['titulo'] ) )
                throw new Exception("Um Título é Necessário!");
            if( empty( $param['recado'] ) )
                throw new Exception("Um Recado é Necessário!");
            
            TTransaction::open(self::$database); // open a transaction
            
            $mural = new Mural();
            $mural->idsystemuser = TSession::getValue('userid');
            $mural->dtinclusao = date("Y-m-d");
            $mural->dtpublicacao = $param['dtpublicacao'] == '' ? date("Y-m-d") :  TDate::date2us($param['dtpublicacao']);
            $mural->titulo = $param['titulo'];
            $mural->post = $param['recado'];
            $mural->store();
            
            TToast::show("success", "Recado Adicionado", "topRight", "fas:comment-alt");
            
            TTransaction::close(); // close the transaction

            
            
            
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
            

        
    }
    
    
    // função executa ao clicar no item de menu
    public function onShow($param = null)
    {
        
    }
}
