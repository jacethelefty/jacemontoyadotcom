var express = require('express');
var app = express();

app.use(express.static('./public'));

var port = process.env.PORT || 3000;
app.listen(port, () => console.log('server up on port: ' + port));

module.exports = app;
