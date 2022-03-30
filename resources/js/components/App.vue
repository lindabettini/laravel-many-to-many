<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <Header :title="title" />
                    <!-- <div class="card-header">Benvenuti</div> -->

                    <div class="card-body">
                        <h2>Sito in costruzione</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Header from "./Header.vue";
export default {
    name: "App",
    components: {
        Header,
    },
    data() {
        return {
            title: "Benvenuti",
        };
    },
};
</script>
