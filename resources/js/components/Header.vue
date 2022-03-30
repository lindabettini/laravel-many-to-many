<template>
    <div class="card-header" v-text="title">Benvenuti</div>
</template>

<script>
export default {
    name: "Header",
    props: ["title"],
};
</script>
