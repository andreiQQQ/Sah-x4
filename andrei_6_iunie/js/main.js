var gameBoard = {};
gameBoard.pieces = new Array(225);
$(function() {
	init();
    initBoard();
    //printBoard();
	console.log("Main Init Called");
    var line = "";
    
    for (i = 1; i <= 224; ++i) {
        line = line + " " + SqAttacked(i, 3, 4);
        if (i % 14 == 0) {
            console.log(line);
            line = "";
        }
    }
    //console.log(SqAttacked(65, 3, 1));
});

function init() {
	console.log("init() called");
}