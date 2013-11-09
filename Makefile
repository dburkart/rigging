html: rigging.php abstractions/*.php
	doxygen docs/Doxyfile

installDocs: html
	git checkout documentation
	cp -Rf html/* .
	git add -A
	git commit -m "Commiting documentation for $(shell git rev-parse HEAD)"
	git checkout master