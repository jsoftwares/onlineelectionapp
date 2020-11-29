<template>
<div>
    <button class="btn btn-sm btn-primary mb-2" @click="createPoll()">New Poll</button>
    
    <div class="clearfix"></div>
    <!-- DataTales Example -->
    <div v-show="showMessage" class="alert alert-success alert-dismisable fade show" role="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>{{message}}</strong>
    </div>

    <div class="container-fluid">
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
        
    },

    components: {
        "poll-candidates": require('./children/PollCandidates.vue').default,
        "poll-votes": require('./children/PollVotes.vue').default
    },

    data() {
        return {
            message:'',
            showMessage: false
        }
    },

    methods:{

        createPoll()
        {},

        showAlert(message, time){
            this.message = message;
            this.showMessage = true;
            
            setInterval(() => {
                this.showMessage = false;
                this.message = '';
            }, time);
        }
    }

}
</script>