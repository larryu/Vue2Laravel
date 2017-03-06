<template>
    <div></div>
</template>

<script>
    export default {
        name: 'treeItem',
        props: {
            item: {
                type: Object,
            }
        },
        data () {
            return {

            }
        },
        created() {
            console.log('TreeItem Component created.')
        },
        components: {
        },
        mounted() {
            console.log('TreeItem Component mounted.')
        }
    }
</script>

<style scoped>
</style>