<template>
    <div class="container-fluid" style="font-family:'century gothic'">
        <div class="card card-default">
            <div class="card-header bg-primary text-white">
                <h5>POLLS RESULT FOR {{event.title}}</h5>
            </div>

            <div class="card-body">

                <!-- <br> -->

                <!-- Actual Poll Display Starts-->
                <div id="accordion">

                    <div class="card" v-for="(poll, index) in polls" :key="index">
                        <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" v-bind:data-target="'#collapse'+poll.id" aria-expanded="true" aria-controls="collapseOne">
                                Vote for {{poll.title}}
                                </button>
                            </h5>
                        </div>

                        <div v-bind:id="'collapse'+poll.id" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">

                            <div class="card-body row">
                                <!-- Candidates Start-->
                                        <div class="media mb-4 col-md-4" v-for="(candidate, index) in poll.candidates" :key="index">
                                            <div class="media-left">
                                                <img src="/img/img_avatar1.png" class="media-object" style="width:60px">
                                            </div>
                                            <div class="media-body">
                                                <h6 class="media-heading font-weight-bold">{{candidate.name}}</h6>
                                                <p><strong>VOTES COUNT: {{candidate.votes}}</strong></p>
                                                <p><strong>STATUS: {{candidate.winner}} - ({{candidate.via}})</strong></p>
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
        setInterval(() => {
            this.loadElectionData();
        }, 3000);
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
            axios.post('/api/polls/votes', {'event_id': this.event.id})
            .then( response => {
                console.log(response.data);
                this.polls = response.data.data;
            })
            .catch( err =>console.log(err));
        }
    }
}
</script>