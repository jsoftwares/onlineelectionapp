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
                            <!-- <th>Status</th> -->
                            <th>Action</th>                     
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>SN</th>
                            <th>Name</th>
                            <!-- <th>Status</th> -->
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
                                        <h5>VOTES: <span class="badge badge-secondary">{{candidate.votes}}</span> <span class="badge badge-info">{{candidateVotePercentage(candidate.votes, poll.votes.length)}}</span></h5>
                                        <!-- <p>VOTES: {{candidate.votes}}</p> -->
                                    </div>
                                </div>
                            </td>
                            <!-- <td>{{candidate.status === 0 ? 'NOT CLEARED' : 'CLEARED'}}</td> -->
                            <td v-if="candidate.id != pollWinner">
                                <button @click="editCandidate(candidate)"  class="btn btn-outline-warning btn-sm"><i class="text-yellow fas fa-edit"></i></button>
                                <button @click="declareWinner(candidate)"  class="btn btn-outline-success btn-sm"><i class="fas fa-trophy"></i></button>
                            </td>
                            <td v-else class="text-center bg-success text-white h4 font-weight-bold">WINNER <i class="fas fa-trophy"></i></td>
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
            'pollCandidates': this.poll.candidates,
            'pollWinner': this.poll.winner
        }
    },

    methods: {
        addCandidate(poll) {
            this.$emit('addNewCandidate', (this.poll));
        },

        declareWinner(candidate)
        {
            axios.post('/api/poll/declare-winner', {
                'candidate': candidate.id,
                'poll': candidate.poll_id,
                'event': this.poll.event_id
            }).then( response =>{
                if (response.status == 200) {
                    this.$parent.$emit('winnerDeclared', candidate.name);
                    this.pollWinner = candidate.id
                }
            }).catch( err => console.log(err));
        },
        candidateVotePercentage(candidateVotesCount, pollVotesCount)
        {
            let percentage = (candidateVotesCount/pollVotesCount) * 100;
            return percentage.toFixed(0)+'%';
        }
    }

}
</script>