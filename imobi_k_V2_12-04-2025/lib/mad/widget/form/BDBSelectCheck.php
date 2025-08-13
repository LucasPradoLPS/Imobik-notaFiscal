
<?php
use Adianti\Widget\Wrapper\AdiantiDatabaseWidgetTrait;

class BDBSelectCheck extends BSelectCheck
{
    
    protected $items; // array containing the combobox options
    
    use AdiantiDatabaseWidgetTrait;
    
    public function __construct($name, $database, $model, $key, $value, $ordercolumn = NULL, TCriteria $criteria = NULL, $cachekey = null)
    {
        // executes the parent class constructor
        parent::__construct($name);
        
        // load items
        parent::addItems( self::getItemsFromModel($database, $model, $key, $value, $ordercolumn, $criteria, $cachekey) );
    }
    
    /**
     * Reload combo from model data
     * @param  $formname    form name
     * @param  $field       field name
     * @param  $database    database name
     * @param  $model       model class name
     * @param  $key         table field to be used as key in the combo
     * @param  $value       table field to be listed in the combo
     * @param  $ordercolumn column to order the fields (optional)
     * @param  $criteria    criteria (TCriteria object) to filter the model (optional)
     * @param  $startEmpty  if the combo will have an empty first item
     * @param  $fire_events  if change action will be fired
     */
    public static function reloadFromModel($formname, $field, $database, $model, $key, $value, $ordercolumn = NULL, $criteria = NULL, $startEmpty = FALSE, $fire_events = TRUE, $cachekey = null)
    {
        // load items
        $items = self::getItemsFromModel($database, $model, $key, $value, $ordercolumn, $criteria, $cachekey);
        
        // reload combo
        parent::reload($formname, $field, $items, $startEmpty, $fire_events);
    }
}
