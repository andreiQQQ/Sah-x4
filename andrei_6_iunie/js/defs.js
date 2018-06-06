var PIECES = {
	EMPTY : 0,
    P1 :  1, // pown / pion
    N1 :  2, // knight / cal
    B1 :  3, // bishop / nebun
    R1 :  4, // rook / tura
    Q1 :  5, // queen / regina
    K1 :  6, // king / rege
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
              

var BRD_SQ_NUM = 120;

var FILES =  { FILE_A: 0, FILE_B: 1, FILE_C: 2, FILE_D: 3, FILE_E: 4, FILE_F:5, FILE_G:6, FILE_H:7, FILE_NONE:8 };
	
var RANKS =  { RANK_1:0, RANK_2:1, RANK_3:2, RANK_4:3, 
	RANK_5:4, RANK_6:5, RANK_7:6, RANK_8:7, RANK_NONE:8 };
	
var COLOURS = { WHITE:0, BLACK:1, BOTH:2 };

var SQUARES = {
  A1:21, B1:22, C1:23, D1:24, E1:25, F1:26, G1:27, H1:28,  
  A8:91, B8:92, C8:93, D8:94, E8:95, F8:96, G8:97, H8:98, 
  NO_SQ:99, OFFBOARD:100
};

var BOOL = { FALSE:0, TRUE:1 };