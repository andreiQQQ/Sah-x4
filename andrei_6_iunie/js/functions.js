function initBoard() {
    "use strict";
    var i, j;
    
    /* sides:
        1
    4       2
        3
    */
    
    
    for (i = 1; i <= 224; i = i + 1) {
        gameBoard.pieces[i] = -1;
    } //dupa initializare, -1 va fi doar in afara tablei de joc
    
    //liber
    for (i = 1; i <= 8; i = i + 1) {
        for (j = 1; j <= 8; j = j + 1) {
            gameBoard.pieces[56 + (i - 1) * 14 + 3 + j] = PIECES.EMPTY;
        }
    }
    
    //aseaza piese in poz de start
    
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
        gameBoard.pieces[i] = PIECES.P4;
    }
    
    //cai
    gameBoard.pieces[33] = 
    gameBoard.pieces[38] = PIECES.N1;
    gameBoard.pieces[83] = gameBoard.pieces[153] = PIECES.N2;
    gameBoard.pieces[187] = gameBoard.pieces[192] = PIECES.N3;
    gameBoard.pieces[72] = gameBoard.pieces[142] = PIECES.N4;
    
    //nebuni
    gameBoard.pieces[34] = gameBoard.pieces[37] = PIECES.B1;
    gameBoard.pieces[97] = gameBoard.pieces[139] = PIECES.B2;
    gameBoard.pieces[188] = gameBoard.pieces[191] = PIECES.B3;
    gameBoard.pieces[86] = gameBoard.pieces[128] = PIECES.B4;
    
    //ture
    gameBoard.pieces[32] = 
    gameBoard.pieces[39] = PIECES.R1;
    gameBoard.pieces[69] = gameBoard.pieces[167] = PIECES.R2;
    gameBoard.pieces[186] = gameBoard.pieces[193] = PIECES.R3;
    gameBoard.pieces[58] = gameBoard.pieces[156] = PIECES.R4;
    
    //regine
    gameBoard.pieces[35] = PIECES.Q1;
    gameBoard.pieces[125] = PIECES.Q2;
    gameBoard.pieces[189] = PIECES.Q3;
    gameBoard.pieces[114] = PIECES.Q4;
    
    //regi
    gameBoard.pieces[36] = PIECES.K1;
    gameBoard.pieces[111] = PIECES.K2;
    gameBoard.pieces[190] = PIECES.K3;
    gameBoard.pieces[100] = PIECES.K4;

}
function isEnemyPawn(sq, side) {
    "use strict";
    var s = Math.trunc((gameBoard.pieces[sq] - 1) / 6 + 1);
    if (gameBoard.pieces[sq] % 6 === 1 && s !== side) {
        return s; //enemy side
    }
    return 0;
}
function isEnemyKnight(sq, side) {
    "use strict";
    var s = Math.trunc((gameBoard.pieces[sq] - 1) / 6 + 1);
    if (gameBoard.pieces[sq] % 6 === 2 && s !== side) {
        return s; //enemy side
    }
    return 0;
}
function isEnemyBishop(sq, side) {
    "use strict";
    var s = Math.trunc((gameBoard.pieces[sq] - 1) / 6 + 1);
    if (gameBoard.pieces[sq] % 6 === 3 && s !== side) {
        return s; //enemy side
    }
    return 0;
}
function isEnemyRook(sq, side) {
    "use strict";
    var s = Math.trunc((gameBoard.pieces[sq] - 1) / 6 + 1);
    if (gameBoard.pieces[sq] % 6 === 4 && s !== side) {
        return s; //enemy side
    }
    return 0;
}
function isEnemyQueen(sq, side) {
    "use strict";
    var s = Math.trunc((gameBoard.pieces[sq] - 1) / 6 + 1);
    if (gameBoard.pieces[sq] % 6 === 5 && s !== side) {
        return s; //enemy side
    }
    return 0;
}
function isEnemyKing(sq, side) {
    "use strict";
    var s = Math.trunc((gameBoard.pieces[sq] - 1) / 6 + 1);
    if (gameBoard.pieces[sq] % 6 === 0 && s !== side) {
        return s; //enemy side
    }
    return 0;
}
var knightMoves = [-29, -27, -12, 16, 29, 27, 12, -16];

//test if sq is attacked
function SqAttacked(sq, own_side, enemy_side) {
    "use strict";
    if (gameBoard.pieces[sq] == -1) {
        return 0;
    }
    var i, enemy, source;
    /*
    //attacked by pawn
    if (isEnemyPawn(sq - 13, own_side) === 1 || isEnemyPawn(sq - 15, own_side) === 1) {
        if (enemy_side == 1) 
            return 1;
    }
    if (isEnemyPawn(sq - 13, own_side) === 2 || isEnemyPawn(sq + 15, own_side) === 2) {
        if (enemy_side == 2) 
            return 1;
    }
    if (isEnemyPawn(sq + 13, own_side) === 3 || isEnemyPawn(sq + 15, own_side) === 3) {
        if (enemy_side == 3) 
            return 1;
    }
    if (isEnemyPawn(sq - 15, own_side) === 4 || isEnemyPawn(sq + 13, own_side) === 4) {
        if (enemy_side == 4) 
            return 1;
    }
    
    
    //attacked by knight
    for (i = 0; i < 8; i = i + 1) {
        enemy = isEnemyKnight(sq + knightMoves[i], own_side);
        if (enemy == enemy_side) {
            return 1;
        }
    }
    
    //attacked by bishop
    source = sq - 15;
    while (gameBoard.pieces[source] === 0) {
        source = source - 15;
    }
    enemy = isEnemyBishop(source, own_side);
    if (enemy == enemy_side) {
        return 1;
    }
    
    source = sq - 13;
    while (gameBoard.pieces[source] === 0) {
        source = source - 13;
    }
    enemy = isEnemyBishop(source, own_side);
    if (enemy == enemy_side) {
        return 1;
    }
    
    source = sq + 15;
    while (gameBoard.pieces[source] === 0) {
        source = source + 15;
    }
    enemy = isEnemyBishop(source, own_side);
    if (enemy == enemy_side) {
        return 1;
    }
    
    source = sq + 13;
    while (gameBoard.pieces[source] === 0) {
        source = source + 13;
    }
    enemy = isEnemyBishop(source, own_side);
    if (enemy == enemy_side) {
        return 1;
    }
    
    //attacked by rook
    source = sq - 14;
    while (gameBoard.pieces[source] === 0) {
        source = source - 14;
    }
    enemy = isEnemyRook(source, own_side);
    if (enemy == enemy_side) {
        return 1;
    }
    
    source = sq - 1;
    while (gameBoard.pieces[source] === 0) {
        source = source - 1;
    }
    enemy = isEnemyRook(source, own_side);
    if (enemy == enemy_side) {
        return 1;
    }
    
    source = sq + 14;
    while (gameBoard.pieces[source] === 0) {
        source = source + 14;
    }
    enemy = isEnemyRook(source, own_side);
    if (enemy == enemy_side) {
        return 1;
    }
    
    source = sq + 1;
    while (gameBoard.pieces[source] === 0) {
        source = source + 1;
    }
    enemy = isEnemyRook(source, own_side);
    if (enemy == enemy_side) {
        return 1;
    }
    
    //attacked by queen
    source = sq - 15;
    while (gameBoard.pieces[source] === 0) {
        source = source - 15;
    }
    enemy = isEnemyQueen(source, own_side);
    if (enemy == enemy_side) {
        return 1;
    }
    
    source = sq - 13;
    while (gameBoard.pieces[source] === 0) {
        source = source - 13;
    }
    enemy = isEnemyQueen(source, own_side);
    if (enemy == enemy_side) {
        return 1;
    }
    
    source = sq + 15;
    while (gameBoard.pieces[source] === 0) {
        source = source + 15;
    }
    enemy = isEnemyQueen(source, own_side);
    if (enemy == enemy_side) {
        return 1;
    }
    
    source = sq + 13;
    while (gameBoard.pieces[source] === 0) {
        source = source + 13;
    }
    enemy = isEnemyQueen(source, own_side);
    if (enemy == enemy_side) {
        return 1;
    }
    
    source = sq - 14;
    while (gameBoard.pieces[source] === 0) {
        source = source - 14;
    }
    enemy = isEnemyQueen(source, own_side);
    if (enemy == enemy_side) {
        return 1;
    }
    
    source = sq - 1;
    while (gameBoard.pieces[source] === 0) {
        source = source - 1;
    }
    enemy = isEnemyQueen(source, own_side);
    if (enemy == enemy_side) {
        return 1;
    }
    
    source = sq + 14;
    while (gameBoard.pieces[source] === 0) {
        source = source + 14;
    }
    enemy = isEnemyQueen(source, own_side);
    if (enemy == enemy_side) {
        return 1;
    }
    
    source = sq + 1;
    while (gameBoard.pieces[source] === 0) {
        source = source + 1;
    }
    enemy = isEnemyQueen(source, own_side);
    if (enemy == enemy_side) {
        return 1;
    }
    */
    
    //attacked by king
    enemy = isEnemyKing(sq - 13, own_side);
    if (enemy == enemy_side) {
        return 1;
    }
    enemy = isEnemyKing(sq - 14, own_side);
    if (enemy == enemy_side) {
        return 1;
    }
    enemy = isEnemyKing(sq - 15, own_side);
    if (enemy == enemy_side) {
        return 1;
    }
    enemy = isEnemyKing(sq - 1, own_side);
    if (enemy == enemy_side) {
        return 1;
    }
    enemy = isEnemyKing(sq + 13, own_side);
    if (enemy == enemy_side) {
        return 1;
    }
    enemy = isEnemyKing(sq + 14, own_side);
    if (enemy == enemy_side) {
        return 1;
    }
    enemy = isEnemyKing(sq + 15, own_side);
    if (enemy == enemy_side) {
        return 1;
    }
    enemy = isEnemyKing(sq + 1, own_side);
    if (enemy == enemy_side) {
        return 1;
    }
    
    return 0;
}

function printBoard() {
    var line = "";
    for (i = 1; i <= 224; ++i) {
        if (gameBoard.pieces[i] < 10) {
            char = " " + gameBoard.pieces[i];
        } else {
            char = "" + gameBoard.pieces[i];
        }
        line = line + " " + char;
        if (i % 14 == 0) {
            console.log(line);
            line = "";
        }
    }
}