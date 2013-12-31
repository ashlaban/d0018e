### --- SHELL --- ###
### ------------- ###

dropdb --if-exists 'cmerc-db'
createdb --encoding='UTF-8' 'cmerc-db'

psql -d 'cmerc-db' -f './db-init.sql'