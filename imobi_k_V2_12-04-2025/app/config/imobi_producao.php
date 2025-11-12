<?php
// Return the unit database config if set in session, otherwise fall back to the system database
$unit_database = TSession::getValue('unit_database');
if (!empty($unit_database))
{
	return TConnection::getDatabaseInfo($unit_database);
}

// fallback to imobi_system when no unit is selected (prevents returning FALSE)
return TConnection::getDatabaseInfo('imobi_system');
