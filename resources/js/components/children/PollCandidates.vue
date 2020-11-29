<template>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <h6 class="m-0 font-weight-bold text-primary col-md-9">Candidates</h6>
                <button class="btn btn-sm btn-primary m-0 float-right col-md-3" @click="addCandidate()">Add Cadidate</button>
            </div>
            
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable-poll" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Action</th>                     
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>SN</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Action</th> 
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr v-for="(candidate, index) in pollCandidates" :key='index'>
                            <td>{{index + 1}}</td>
                            <td class='font-weight-bold'>
                                <div class="media mb-4 mr-4">
                                    <div class="media-left">
                                        <img src="/img/img_avatar1.png" class="media-object" style="width:50px">
                                    </div>
                                    <div class="media-body">
                                        <h6 class="media-heading">{{candidate.name}}</h6>
                                        <p>VOTES: {{candidate.votes}}</p>
                                    </div>
                                </div>
                            </td>
                            <td>{{candidate.status === 0 ? 'NOT CLEARED' : 'CLEARED'}}</td>
                            <td>
                                <button @click="editCandidate(candidate)"  class='btn btn-outline-warning btn-sm'><i class="text-yellow fas fa-edit"></i></button>
                                <button @click="makeWinner(candidate)" v-show="candidate.won==null"  class='btn btn-outline-success btn-sm'><i class="fas fa-trophy"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <add-candidate></add-candidate>
    </div>

</template>

<script>
export default {
    props:['poll'],

    mounted() {

        this.$on('candidateCreated', (data) => {
            // this.allPolls.push(data.candidate);
            this.$parent.$emit('candidateCreated');
        });
    },

    components: {
        "add-candidate": require('./AddCandidate.vue').default
    },


    data() {
        return {
            'pollCandidates': this.poll.candidates
        }
    },

    methods: {
        addCandidate(poll) {
            this.$emit('addNewCandidate', (this.poll));
        },

        makeWinner(candidate)
        {
            axios.post('/api/poll/declare-winner', {
                'candidate_id': candidate.id,
                'poll': candidate.poll_id
            }).then( response ).catch( err => console.log(err));
        }
    }

}
</script>