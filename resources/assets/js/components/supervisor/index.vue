<template>
    <div>

        <supervisor-tabs></supervisor-tabs>

    </div>
</template>
<style>

</style>
<script>
    import supervisorTabs from './modulos/supervisorTabs.vue'
    export default{
        data(){
            return {
                msg: 'hello vue'
            }
        },
        components: {
            'supervisor-tabs': supervisorTabs
        }
    }
</script>
