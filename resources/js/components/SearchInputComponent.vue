<template>
    <div>
        <div class="input-group">
            <input type="text" class="form-control form-control--search" placeholder="Search by author's name..." v-model="test">

            <div class="input-group-append ml-1">
                <a class="btn btn-outline-secondary btn--search" :href="'/search?name=' + test">Search</a>
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
