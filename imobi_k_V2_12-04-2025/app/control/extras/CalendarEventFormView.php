<?php
/**
 * CalendarEventForm Form
 * @author  <your name here>
 */
class CalendarEventFormView extends TPage
{
    private $fc;

    /**
     * Page constructor
     */
    public function __construct($param = null)
    {
        parent::__construct();

        $this->fc = new TFullCalendar(date('Y-m-d'), 'month');
        $this->fc->enableDays([0,1,2,3,4,5,6]);
        $this->fc->setReloadAction(new TAction(array($this, 'getEvents'), $param));
        $this->fc->setDayClickAction(new TAction(array('CalendarEventForm', 'onStartEdit')));
        $this->fc->setEventClickAction(new TAction(array('CalendarEventForm', 'onEdit')));
        $this->fc->setEventUpdateAction(new TAction(array('CalendarEventForm', 'onUpdateEvent')));
        $this->fc->setCurrentView('month');
        $this->fc->setTimeRange('06:00', '23:00');
        $this->fc->enablePopover('Evento', " {description} ");
        $this->fc->setOption('slotTime', "00:30:00");
        $this->fc->setOption('slotDuration', "00:30:00");
        $this->fc->setOption('slotLabelInterval', 30);

        parent::add( $this->fc );
    }

    /**
     * Output events as an json
     */
    public static function getEvents($param=NULL)
    {
        $return = array();
        try
        {
            TTransaction::open('imobi_producao');

            $criteria = new TCriteria(); 

            $criteria->add(new TFilter('start_time', '<=', substr($param['end'], 0, 10).' 23:59:59'));
            $criteria->add(new TFilter('end_time', '>=', substr($param['start'], 0, 10).' 00:00:00'));

            $criteria->add(new TFilter('systemuser', '=', TSession::getValue("userid")));
            $criteria->add(new TFilter('privado', 'IS', FALSE), TExpression::OR_OPERATOR);

            $events = CalendarEvent::getObjects($criteria);

            if ($events)
            {
                foreach ($events as $event)
                {
                    $event_array = $event->toArray();
                    $event_array['start'] = str_replace( ' ', 'T', $event_array['start_time']);
                    $event_array['end'] = str_replace( ' ', 'T', $event_array['end_time']);
                    $event_array['id'] = $event->id;
                    $event_array['color'] = $event->render("{color}");

                    $titulo = $event->privado ? '<i class="fas fa-lock"></i> ' . $event->title : '<i class="fas fa-lock-open"></i> '. $event->title;
                    $event_array['title'] = TFullCalendar::renderPopover($event->render($titulo), $event->render("Evento"), $event->render(" {description} "));

                    $return[] = $event_array;
                }
            }
            TTransaction::close();
            echo json_encode($return);
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }

    /**
     * Reconfigure the callendar
     */
    public function onReload($param = null)
    {
        if (isset($param['view']))
        {
            $this->fc->setCurrentView($param['view']);
        }

        if (isset($param['date']))
        {
            $this->fc->setCurrentDate($param['date']);
        }
    }

}

