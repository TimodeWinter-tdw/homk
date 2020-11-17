<template>
    <div class="mb-2">
        <div class="w-full rounded shadow-lg bg-red-600 text-white p-3" v-if="error">
            {{error}}
        </div>
        <div class="w-full rounded shadow-lg bg-green-600 text-white p-3" v-if="success">
            {{success}}
        </div>
    </div>
</template>

<script>
export default {
    name: "FlashMessages",
    props: {
        error: String,
        success: String
    }
}
</script>

<style scoped>

</style>
