cd /home/alex/Escritorio/
find . -type d -exec sh -c '(cd {} && sh crawler.sh)' ';'
