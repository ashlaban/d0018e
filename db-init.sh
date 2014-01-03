### --- SHELL --- ###
### ------------- ###

# TODO: Add information that this will wipe db.
# TODO: Calling like 'db-init -f' should supress above question

dropdb --if-exists 'cmerc-db'
createdb --encoding='UTF-8' --template='template0' 'cmerc-db'

psql -d 'cmerc-db' -f './db-init.sql'