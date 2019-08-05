<template>
    <div id="arrange_tasks_wrapper" class="container">
        <div class="row justify-content-center">
            <div class="col-9">
                <div class="table-responsive">
                    <h2 class="text-center mb-3">Arrange Tasks</h2>
                    <table id="arrange_tasks_table" class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Day</th>
                                <th>Type</th>
                                <th>Task/Story Name</th>
                            </tr>
                        </thead>
                        
                        <draggable :list="groups" :options="{animation:200, handle:'.handle'}" :element="'tbody'" @change="update">

                            <tr v-for="(item, index) in groups">
                                <td><i class="fas fa-bars handle font-weight-bold lead"></i></td>
                                <td>
                                    <span v-if="item.standalone">{{ item.start_day }}</span>
                                    <span v-else>{{ item.start_day }} - {{ item.end_day }}</span>
                                </td>
                                <td>
                                    <span v-if="item.standalone">Simple Task</span>
                                    <span v-else>Story</span>
                                </td>
                                <td>
                                    <input v-if="item.standalone" v-model="item.task.name">
                                    <input v-else v-model="item.story.name" disabled>
                                </td>
                            </tr>

                        </draggable>

                    </table>
                    <div class="text-center">
                        <button v-on:click="submit" class="btn btn-primary btn-lg px-5">
                            <span v-if="loading"><i class="fas fa-spinner fa-spin"></i></span>
                            <span v-else>Submit</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <h2 class="text-center mb-3">Preview</h2>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>Absolute Day</th>
                                <th>Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(task, index) in project_tasks">
                                <td>{{ task.absolute_day }}</td>
                                <td>{{ task.name }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        components: {
            draggable
        },

        props: [
            'project', 
            'task_groups', 
        ],

        data() {
            return {
                loading: 0,
                groups: Object.values(this.task_groups),
            }
        },

        methods: {
            update() {
                var day = 1;
                this.groups.map((group, index) => {
                    group.start_day = day;
                    if(group.standalone){
                        group.task.absolute_day = day
                        day++;
                    } else {
                        group.start_day = day;
                        group.story.project_tasks.forEach(function(task, index){
                            task.absolute_day = day;
                            group.end_day = day;
                            day++;
                        })
                    }
                });
            },
            submit() {
                var self = this
                self.loading = 1;
                axios({
                    method: 'post',
                    url: '/project/'+self.project.id+'/tasks/arrange',
                    data: {
                        project_tasks: this.project_tasks
                    }
                }).then(function (response) {
                    self.loading = 0;
                    self.groups = Object.values(response.data)
                })
                .catch(function (error) {
                    self.loading = 0;
                    if(typeof error.response.data.errors != 'undefined'){
                        console.log(error.response.data.errors);
                    } else {
                        console.log(error);
                    }
                });;
            }
        },


        computed: {
            project_tasks: function(){
                var result = [];
                this.groups.forEach(function(item, index){
                    if(item.standalone){
                        result.push(item.task);
                    } else {
                        item.story.project_tasks.forEach(function(task, index){
                            result.push(task);
                        });
                    }
                });
                return result;
            }
        },

    }
</script>
