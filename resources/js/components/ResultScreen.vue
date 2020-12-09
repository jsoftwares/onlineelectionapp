<template>
    <div class="container-fluid" style="font-family:'century gothic'">
        <div class="card card-default">
            <div class="card-header bg-primary text-white">
                <h5>LIVE RESULTS FOR {{event.title}}</h5>
            </div>

            <div class="card-body">

                <!-- <br> -->

                <!-- Actual Poll Display Starts-->
                <div id="accordion">

                    <div class="card" v-for="(poll, index) in polls" :key="index">
                        <div class="card-header m-0 p-0" id="headingOne">
                            
                                <button class="btn btn-link" data-toggle="collapse" v-bind:data-target="'#collapse'+poll.id" aria-expanded="true" aria-controls="collapseOne">
                                <h5 class="mb-0 font-weight-bold">Vote for {{poll.title}}</h5>
                                </button>
 
                        </div>

                        <div v-bind:id="'collapse'+poll.id" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">

                            <div class="card-body row">
                                <!-- Candidates Start-->
                                        <div class="media mb-4 col-md-4" v-for="(candidate, index) in poll.candidates" :key="index">
                                            <div class="media-left">
                                                <img src="/img/img_avatar1.png" class="media-object" style="width:60px">
                                            </div>
                                            <div class="media-body">
                                                <h5 class="media-heading font-weight-bold">{{candidate.name}}</h5>
                                                <h4>VOTES: <span class="badge badge-secondary">{{candidate.votes}}</span> <span class="badge badge-info">{{candidateVotePercentage(candidate.votes, poll.votes.length)}}</span></h4>
                                                <!-- <p><strong>STATUS: {{candidate.winner}} - ({{candidate.via}})</strong></p> -->
                                                <!-- <p>{{candidateVotePercentage(candidate.votes, poll.votes.length)}}</p> -->
                                                
                                            </div>
                                        </div>
                                    <!-- Candidate Stop -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Actual Poll Display Ends -->
                
            </div>
        </div>
    </div>
</template>

<script>
export default {
    
    props: ['event'],

    mounted()
    {
        this.loadElectionData();
    },

    created()
    {
        let getData;
        if (this.event.status == 1) {
            getData = setInterval(() => {       
                this.loadElectionData();
            }, 3000);
        }else{
            clearInterval(getData)
        }
    },

    data()
    {
        return {
            polls: []
        }
    },

    methods: {
        loadElectionData()
        {
            axios.post('/api/eventpolls/votes', {'event_id': this.event.id})
            .then( response => {
                this.polls = response.data.data;
            })
            .catch( err =>console.log(err));
        },

        candidateVotePercentage(candidateVotesCount, pollVotesCount)
        {
            let percentage = (candidateVotesCount/pollVotesCount) * 100;
            return percentage.toFixed(0)+'%';
        }
    }
}
</script>