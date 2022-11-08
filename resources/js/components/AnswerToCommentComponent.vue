<template>
    <div>
        <button @click="clicked = !clicked" class="btn btn-secondary">Answer</button>

        <form action="#" @submit.prevent="answer">
            <div class="input-group mt-3" v-if="clicked">
                <input v-model="form.text"
                       type="text"
                       name="text"
                       class="form-control"
                       placeholder="Your answer..."
                       required>

                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Comment</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        props: ['commentId', 'workId'],

        data() {
            return {
                clicked: false,
                form: new Form({
                    text: ''
                })
            }
        },

        methods: {
            answer() {
                this.form.post('/work/' + this.workId + '/comment/' + this.commentId + '/create')
                    .then((response) => {
                        window.location.reload();
                    })
                    .catch(errors => {
                        if (errors.response.status === 401) {
                            window.location = '/login';
                        }
                    });
            }
        }
    }
</script>
