<?php

function dbConnect()
{
	$conn = pg_connect( "dbname=testdb user=db-man" );
	if (!$conn)
	{
		die( "{'error':'Database unreachable'}" );
	}

	return $conn;
}

function dbSQL( $conn, $cmd )
{
	$sql = pg_query( $conn, $cmd );
	if (!$sql)
	{
		die( "{'error':'Could not execute sql-command..!'}" );
	}

	return $sql;
}

function dbConnectAndSQL( $cmd )
{
	$conn = dbConnect();
	$sql  = dbSQL( $conn, $cmd );

	return $sql;
}

// Based on code from: http://www.bin-co.com/php/scripts/sql2json/
// Function will take an SQL query as an argument and format the resulting data as a 
//    json(JavaScript Object Notation) string and return it.
function sql2json( $sql )
{
    $json_str = "";

    //See if there is anything in the query
    if( $total = pg_num_rows($sql) )
    {
        $json_str .= "[\n";

        $row_count = 0;
        while( $data = pg_fetch_assoc($sql) )
        {
            if ( count($data) > 1 )
            {
            	$json_str .= "{\n";
            }

            $count = 0;
            foreach($data as $key => $value)
            {
                //If it is an associative array we want it in the format of "key":"value"
                if( count($data) > 1)
                {
                	$json_str .= "\"$key\":\"$value\"";
                }
                else 
                {
                	$json_str .= "\"$value\"";
                }

                //Make sure that the last item don't have a ',' (comma)
                $count++;
                if ( $count < count($data) ) $json_str .= ",\n";
            }
            $row_count++;
            if ( count($data) > 1 ) $json_str .= "}\n";

            //Make sure that the last item don't have a ',' (comma)
            if($row_count < $total) $json_str .= ",\n";
        }

        $json_str .= "]\n";
    }

    //Replace the '\n's - make it faster - but at the price of bad redability.
    $json_str = str_replace("\n","",$json_str); //Comment this out when you are debugging the script

    //Finally, output the data
    return $json_str;
}