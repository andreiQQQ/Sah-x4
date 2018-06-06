var PIECES = {
	EMPTY : 0,
    P1 :  1,
    N1 :  2,
    B1 :  3,
    R1 :  4,
    Q1 :  5,
    K1 :  6,
    P2 :  7,
    N2 :  8,
    B2 :  9,
    R2 : 10,
    Q2 : 11,
    K2 : 12,
    P3 : 13,
    N3 : 14,
    B3 : 15,
    R3 : 16,
    Q3 : 17,
    K3 : 18,
    P4 : 19,
    N4 : 20,
    B4 : 21,
    R4 : 22,
    Q4 : 23,
    K4 : 24
};
var gameBoard;
gameBoard.pieces = new Array(225);
function initBoard() {
    "use strict";
    var i, j;
    
    //afara
    for (i = 1; i <= 16; i = i + 1) {
        for (j = 1; j <= 14; j = j + 1) {
            gameBoard[14 * (i - 1) + j] = -1;
        }
    }
    
    //liber
    for (i = 1; i <= 8; i = i + 1) {
        for (j = 1; j <= 8; j = j + 1) {
            gameBoard[56 + (i - 1) * 14 + 3 + j] = PIECES.EMPTY;
        }
    }
    
    //pioni
    for (i = 46; i <= 53; i = i + 1) {
        gameBoard.pieces[i] = PIECES.P1;
    }
    for (i = 68; i <= 166; i = i + 14) {
        gameBoard.pieces[i] = PIECES.P2;
    }
    for (i = 172; i <= 179; i = i + 1) {
        gameBoard.pieces[i] = PIECES.P3;
    }
    for (i = 59; i <= 157; i = i + 14) {
        gameBoard.pieces[i] = PIECES.P2;
    }
    
    //cai
    gameBoard.pieces[33] = gameBoard.pieces[38] = PIECES.N1;
    gameBoard.pieces[83] = gameBoard.pieces[153] = PIECES.N2;
    gameBoard.pieces[187] = gameBoard.pieces[192] = PIECES.N3;
    gameBoard.pieces[72] = gameBoard.pieces[142] = PIECES.N4;
    
    //nebuni
    gameBoard.pieces[34] = gameBoard.pieces[37] = PIECES.B1;
    gameBoard.pieces[97] = gameBoard.pieces[139] = PIECES.B2;
    gameBoard.pieces[188] = gameBoard.pieces[191] = PIECES.B3;
    gameBoard.pieces[86] = gameBoard.pieces[128] = PIECES.B4;
    
    //ture
    gameBoard.pieces[32] = gameBoard.pieces[39] = PIECES.R1;
    gameBoard.pieces[69] = gameBoard.pieces[167] = PIECES.R2;
    gameBoard.pieces[186] = gameBoard.pieces[193] = PIECES.R3;
    gameBoard.pieces[58] = gameBoard.pieces[156] = PIECES.R4;
    
    //regine
    gameBoard.pieces[35] = PIECES.Q1;
    gameBoard.pieces[125] = PIECES.Q2;
    gameBoard.pieces[189] = PIECES.Q3;
    gameBoard.pieces[114] = PIECES.Q3;
    
    //regi
    gameBoard.pieces[36] = PIECES.K1;
    gameBoard.pieces[111] = PIECES.K2;
    gameBoard.pieces[190] = PIECES.K3;
    gameBoard.pieces[100] = PIECES.K3;
}

function isEnemyPawn(sq, side) {
    "use strict";
    if (gameBoard.pieces[sq] % 6 === 1 && (gameBoard.pieces[sq] - 1) / 6 + 1 !== side) {
        return (gameBoard.pieces[sq] - 1) / 6 + 1; //enemy side
    }
    return 0;
}
function isEnemyKnight(sq, side) {
    "use strict";
    if (gameBoard.pieces[sq] % 6 === 2 && (gameBoard.pieces[sq] - 1) / 6 + 1 !== side) {
        return (gameBoard.pieces[sq] - 1) / 6 + 1; //enemy side
    }
    return 0;
}
function isEnemyBishop(sq, side) {
    "use strict";
    if (gameBoard.pieces[sq] % 6 === 3 && (gameBoard.pieces[sq] - 1) / 6 + 1 !== side) {
        return (gameBoard.pieces[sq] - 1) / 6 + 1; //enemy side
    }
    return 0;
}
function isEnemyRook(sq, side) {
    "use strict";
    if (gameBoard.pieces[sq] % 6 === 4 && (gameBoard.pieces[sq] - 1) / 6 + 1 !== side) {
        return (gameBoard.pieces[sq] - 1) / 6 + 1; //enemy side
    }
    return 0;
}
function isEnemyQueen(sq, side) {
    "use strict";
    if (gameBoard.pieces[sq] % 6 === 5 && (gameBoard.pieces[sq] - 1) / 6 + 1 !== side) {
        return (gameBoard.pieces[sq] - 1) / 6 + 1; //enemy side
    }
    return 0;
}
function isEnemyKing(sq, side) {
    "use strict";
    if (gameBoard.pieces[sq] % 6 === 6 && (gameBoard.pieces[sq] - 1) / 6 + 1 !== side) {
        return (gameBoard.pieces[sq] - 1) / 6 + 1; //enemy side
    }
    return 0;
}
var knightMoves = [-29, -27, -12, 16, 29, 27, 12, -16];
function SqAttacked(sq, side) {
    "use strict";
    var i, enemy, source;
    
    //attacked by pawn
    if (isEnemyPawn(sq - 13, side) === 1 || isEnemyPawn(sq - 15, side) === 1) {
        return 1;
    }
    if (isEnemyPawn(sq - 13, side) === 2 || isEnemyPawn(sq + 15, side) === 2) {
        return 2;
    }
    if (isEnemyPawn(sq + 13, side) === 3 || isEnemyPawn(sq + 15, side) === 3) {
        return 3;
    }
    if (isEnemyPawn(sq - 15, side) === 4 || isEnemyPawn(sq + 13, side) === 4) {
        return 4;
    }
    
    //attacked by knight
    for (i = 0; i < 8; i = i + 1) {
        enemy = isEnemyKnight(sq + knightMoves[i], side);
        if (enemy !== 0) {
            return enemy;
        }
    }
    
    //attacked by bishop
    source = sq - 15;
    while (gameBoard.pieces[source] === 0) {
        source = source - 15;
    }
    enemy = isEnemyBishop(source, side);
    if (enemy) {
        return enemy;
    }
    
    source = sq - 13;
    while (gameBoard.pieces[source] === 0) {
        source = source - 13;
    }
    enemy = isEnemyBishop(source, side);
    if (enemy) {
        return enemy;
    }
    
    source = sq + 15;
    while (gameBoard.pieces[source] === 0) {
        source = source + 15;
    }
    enemy = isEnemyBishop(source, side);
    if (enemy) {
        return enemy;
    }
    
    source = sq + 13;
    while (gameBoard.pieces[source] === 0) {
        source = source + 13;
    }
    enemy = isEnemyBishop(source, side);
    if (enemy) {
        return enemy;
    }
    
    //attacked by rook
    source = sq - 14;
    while (gameBoard.pieces[source] === 0) {
        source = source - 14;
    }
    enemy = isEnemyRook(source, side);
    if (enemy) {
        return enemy;
    }
    
    source = sq - 1;
    while (gameBoard.pieces[source] === 0) {
        source = source - 1;
    }
    enemy = isEnemyRook(source, side);
    if (enemy) {
        return enemy;
    }
    
    source = sq + 14;
    while (gameBoard.pieces[source] === 0) {
        source = source + 14;
    }
    enemy = isEnemyRook(source, side);
    if (enemy) {
        return enemy;
    }
    
    source = sq + 1;
    while (gameBoard.pieces[source] === 0) {
        source = source + 1;
    }
    enemy = isEnemyRook(source, side);
    if (enemy) {
        return enemy;
    }
    
    //attacked by queen
    source = sq - 15;
    while (gameBoard.pieces[source] === 0) {
        source = source - 15;
    }
    enemy = isEnemyQueen(source, side);
    if (enemy) {
        return enemy;
    }
    
    source = sq - 13;
    while (gameBoard.pieces[source] === 0) {
        source = source - 13;
    }
    enemy = isEnemyQueen(source, side);
    if (enemy) {
        return enemy;
    }
    
    source = sq + 15;
    while (gameBoard.pieces[source] === 0) {
        source = source + 15;
    }
    enemy = isEnemyQueen(source, side);
    if (enemy) {
        return enemy;
    }
    
    source = sq + 13;
    while (gameBoard.pieces[source] === 0) {
        source = source + 13;
    }
    enemy = isEnemyQueen(source, side);
    if (enemy) {
        return enemy;
    }
    
    source = sq - 14;
    while (gameBoard.pieces[source] === 0) {
        source = source - 14;
    }
    enemy = isEnemyQueen(source, side);
    if (enemy) {
        return enemy;
    }
    
    source = sq - 1;
    while (gameBoard.pieces[source] === 0) {
        source = source - 1;
    }
    enemy = isEnemyQueen(source, side);
    if (enemy) {
        return enemy;
    }
    
    source = sq + 14;
    while (gameBoard.pieces[source] === 0) {
        source = source + 14;
    }
    enemy = isEnemyQueen(source, side);
    if (enemy) {
        return enemy;
    }
    
    source = sq + 1;
    while (gameBoard.pieces[source] === 0) {
        source = source + 1;
    }
    enemy = isEnemyQueen(source, side);
    if (enemy) {
        return enemy;
    }
    
    //attacked by king
    enemy = isEnemyKing(sq - 14, side);
    if (enemy) {
        return enemy;
    }
    
    enemy = isEnemyKing(sq - 1, side);
    if (enemy) {
        return enemy;
    }
    
    enemy = isEnemyKing(sq + 14, side);
    if (enemy) {
        return enemy;
    }
    
    enemy = isEnemyKing(sq + 1, side);
    if (enemy) {
        return enemy;
    }
    
    return 0;
}