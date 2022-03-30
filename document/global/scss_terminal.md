# install Command
npm install node-sass --save-dev

> after install
in package.json file 
add or check this

"scripts": {"compile:sass":"node-sass sass/main.scss css/style.css -w"}

> after done this
for running sass or scss watch
open terminal and run this command

npm run compile:sass

> for watch run this

npm run compile:sass -w