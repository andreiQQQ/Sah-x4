<template>
    <div class="styledGame">
        <div v-for="row in squareClasses" class="row">
            <div v-for="col in row"
                 :class="col.class">
        </div>
    </div>
    </div>
</template>

<script>
    export default {
        data: () => ({
            gameTable: [],
            squareClasses: (() => {
                let squareClasses = [];
                for (let row = 0; row < 12; row++) {
                    squareClasses[row] = [];
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
                    }
                }
                return squareClasses;
            })()
        }),

        props: {
            gameTableInput: {
                type: Object,
            }
        },

        mounted() {
            this.gameTable = this.gameTableInput;
        },

        methods: {}
    }
</script>
