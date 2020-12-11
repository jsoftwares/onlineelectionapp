<template>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <h6 class="m-0 font-weight-bold text-primary col-md-9">All Polls</h6>
                
                <div class="btn-group float-right col-md-3 p-0" role="group" aria-label="Button group with nested dropdown">
                    <div class="btn-group col-md-12 col-sm-12 p-0" role="group">
                        <button id="btnGroupDrop1" type="button" class="d-none d-sm-inline-block btn btn-sm btn-primary m-0 shadow-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-poll fa-sm text-white-50"></i> Manage Polls
                        </button>
                        <div class="dropdown-menu col-md-12" aria-labelledby="btnGroupDrop1">
                            <a href="#" @click.prevent="createPoll()" class="d-none d-sm-inline-block dropdown-item shadow-sm"> New Poll</a>
                            <a :href="'/event/pollscreen/'+eventId" target="_blank" class="d-none d-sm-inline-block dropdown-item shadow-sm"> Live Result</a>
                        </div>
                    </div>
                </div>
                <!-- <button class="btn btn-sm btn-primary m-0 float-right col-md-3" @click="createPoll()">New Poll</button> -->
            </div>
            
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable-poll" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Title</th>
                            <th>Votes</th>
                            <th>Status</th>
                            <th>Action</th>                     
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>SN</th>
                            <th>Title</th>
                            <th>Votes</th>
                            <th>Status</th>
                            <th>Action</th> 
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr v-for="(poll, index) in allPolls" :key='index'>
                            <td>{{index + 1}}</td>
                            <td class='font-weight-bold'><a :href="'/poll/'+poll.id">{{poll.title}}</a></td>
                            <td>{{poll.votes_count}}</td>
                            <td>{{poll.status === 0 ? 'CLOSE' : 'OPEN'}}</td>
                            <td>
                                <button @click="editPoll(poll)"  class='btn btn-outline-warning btn-sm'><i class="text-yellow fas fa-edit"></i></button>
                                <button @click="addCandidate(poll)"  class='btn btn-outline-success btn-sm'><i class="text-yellow fas fa-plus"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <create-poll></create-poll>
        <add-candidate></add-candidate>
    </div>

</template>

<script>
export default {
    props:['polls', 'eventId'],

    mounted() {
        this.$on('pollCreated', (data) => {
            this.allPolls.push(data.poll);
            this.$parent.$emit('pollCreated');
        });

        this.$on('candidateCreated', (data) => {
            // this.allPolls.push(data.candidate);
            this.$parent.$emit('candidateCreated');
        });
    },

    components: {
        "create-poll": require('./CreatePoll.vue').default,
        "add-candidate": require('./AddCandidate.vue').default
    },


    data() {
        return {
            allPolls : this.polls
        }
    },

    methods: {
        createPoll(){
            this.$emit('createNewPoll', (this.eventId));
        },

        addCandidate(poll) {
            this.$emit('addNewCandidate', (poll));
        }
    }

}
</script>