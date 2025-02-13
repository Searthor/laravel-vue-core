<template>
    <div>
        <h1>Home</h1>

        <!-- Score Counter -->
        <div class="p-4 text-center flex justify-center" style="background: gainsboro;">
            <button class="btn btn-danger" @click="decreaseScore">-</button>
            <p class="mx-4">{{ score }}</p>
            <button class="btn btn-success" @click="increaseScore">+</button>
        </div>

        <!-- Number Input Section -->
        <div class="p-4 text-center mt-2" style="background: gainsboro;">
            <div class="row justify-content-center">
                <div class="col-md-2">
                    <input type="number" class="form-control" v-model.number="num1" placeholder="Enter number">
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control" v-model.number="num2" placeholder="Enter number">
                </div>
                <div class="col-md-2">
                    <p class="text-xl">{{ sum }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            score: 0, // Score counter
            num1: 0,  // First input
            num2: 0   // Second input
        };
    },
    computed: {
        sum() {
            return this.num1 + this.num2;
        }
    },
    methods: {
        increaseScore() {
            this.score++;
        },
        decreaseScore() {
            if (this.score > 0) {
                this.score--;
            }
        }
    }
};
</script>

<style scoped>
p {
    font-size: 1.5rem;
    font-weight: bold;
}
</style>