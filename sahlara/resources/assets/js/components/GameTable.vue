<template>
    <div class="styledGame">
        <div v-for="(row, keyRow) in gameTable" class="row">
            <div v-for="(col, keyCol) in row" v-on:click=""
                 :class="col.class">
                <template v-if="col.piece">{{ col.piece.code }}</template>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: () => ({
            gameTable: {},
        }),

        props: {
            gamePieces: {
                type: Object,
            }
        },

        mounted() {
            let squareClasses = {};
            for (let row = 0; row < 12; row++) {
                squareClasses[row] = {};
                for (let column = 0; column < 12; column++) {
                    if ((column < 2 && row < 2) || (column < 2 && row > 9) ||
                        (column > 9 && row < 2) || (column > 9 && row > 9)) {
                        squareClasses[row][column] = {class: ["square", "hidden"]};
                    }
                    else if ((column % 2 == 1 && row % 2 == 1) || (column % 2 == 0 && row % 2 == 0)) {
                        squareClasses[row][column] = {class: ["square", "light"]};
                    }
                    else if ((column % 2 == 0 && row % 2 == 1) || (column % 2 == 1 && row % 2 == 0)) {
                        squareClasses[row][column] = {class: ["square", "dark"]};
                    }

                    try {
                        squareClasses[row][column].piece = this.gamePieces[row][column];
                    } catch (e) {

                    }
                }
            }

            this.gameTable = squareClasses;
        },

        methods: {

        }
    }
</script>
