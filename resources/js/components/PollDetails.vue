<template>
<div>
    
    <div class="clearfix"></div>
    <a :href="'/event/'+poll.event_id"  class='btn btn-primary btn-sm'>back</a>
    <!-- DataTales Example -->
    <div v-show="showMessage" class="alert alert-success alert-dismisable fade show" role="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>{{message}}</strong>
    </div>
    <div class="container">
            <h4>{{poll.title}}</h4>
    <!-- Nav tabs -->
        <ul class="nav nav-tabs mt-4">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#candidates"><h6 class="font-weight-bold">Candidates</h6></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#votes"><h6 class="font-weight-bold">Votes</h6></a>
            </li>
        </ul>

    <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="candidates">
                <poll-candidates :poll="poll"></poll-candidates>
            </div>
            <div class="tab-pane  fade" id="votes">
                <poll-votes :pollVotes="poll.votes"></poll-votes>
            </div>
        </div>

    </div>

</div>
</template>

<script>
export default {
    props: ['poll'],

    mounted() {
        this.$on('winnerDeclared', candidateName => {
            this.showAlert(candidateName+ ' has been declared winner.', 'alert-success', 5000);
        })
    },

    components: {
        "poll-candidates": require('./children/PollCandidates.vue').default,
        "poll-votes": require('./children/PollVotes.vue').default
    },

    data() {
        return {
            message:'',
            showMessage: false,
            className: ''
        }
    },

    methods:{

        createPoll()
        {},

        showAlert(message, className, time){
            this.message = message;
            this.showMessage = true;
            this.className = className;
            
            setInterval(() => {
                this.showMessage = false;
                this.message = '';
                this.className = '';
            }, time);
        }
    }

}
</script>