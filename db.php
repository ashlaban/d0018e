<?php

function dbConnect()
{
    // TODO: Read this information from external file. Placed in special directory?
    $dbh = new PDO('pgsql:user=db-man-public password=thisisaHorseBatteryStaple dbname=cmerc-db');
	if (!$dbh)
	{
		die( "{'error':'Database unreachable'}" );
	}

    return $dbh;
}

// Based on code from: http://www.bin-co.com/php/scripts/sql2json/
// Function will take a PDO executed statement as argument and format the
//  resulting data as a JSON (JavaScript Object Notation) string and return it.
function sql2json( $sql )
{
    $json_str = "";

    //See if there is anything in the query
    if( $total = $sql->rowCount() )
    {
        $json_str .= "[\n";

        $row_count = 0;
        while( $data = $sql->fetch(PDO::FETCH_ASSOC) )
        {
            if ( count($data) > 1 ) { $json_str .= "{\n"; }

            $count = 0;
            foreach($data as $key => $value)
            {
                //If it is an associative array we want it in the format of "key":"value"
                if( count($data) > 1) { $json_str .= "\"$key\":\"$value\""; }
                else                  { $json_str .=          "\"$value\""; }

                //Make sure that the last item don't have a ',' (comma)
                $count++;
                if ( $count < count($data) ) { $json_str .= ",\n"; }
            }
            $row_count++;
            if ( count($data) > 1 ) { $json_str .= "}\n"; }

            //Make sure that the last item don't have a ',' (comma)
            if($row_count < $total) { $json_str .= ",\n"; }
        }

        $json_str .= "]\n";
    }

    //Replace the '\n's - make it faster - but at the price of bad redability.
    $json_str = str_replace("\n","",$json_str); //Comment this out when you are debugging the script

    //Finally, output the data
    return $json_str;
}