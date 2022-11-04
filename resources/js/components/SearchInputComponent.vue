<template>
    <div>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Search by author's name..." v-model="test">

            <div class="input-group-append">
                <a class="btn btn-outline-secondary" :href="'/search?name=' + test">Search</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                test: ''
            }
        }
    }
</script>
