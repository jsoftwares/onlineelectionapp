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
            <h4>{{currentEvent.title}}</h4>
    <!-- Nav tabs -->
        <ul class="nav nav-tabs mt-4">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#polls"><h6 class="font-weight-bold">Polls</h6></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#attendees"><h6 class="font-weight-bold">Attendees</h6></a>
            </li>
        </ul>

    <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="polls">
                <event-polls :polls="eventPolls" :eventId="currentEvent.id"></event-polls>
            </div>
            <div class="tab-pane  fade" id="attendees">
                <event-attendees :eventId="currentEvent.id"></event-attendees>
            </div>
        </div>

    </div>

</div>
</template>

<script>
export default {
    props: ['event'],

    mounted() {
        this.$on('pollCreated', () => {
            this.showAlert('Poll created successfully.', 4000);
        });

        this.$on('candidateCreated', () => {
            this.showAlert('Candidate created successfully.', 4000);
        });

        this.$on('attendeeCreated', () => {
            this.showAlert('Attendee created successfully.', 4000);
        });
    },

    components: {
        "event-polls": require('./children/EventPolls.vue').default,
        "event-attendees": require('./children/EventAttendees.vue').default
    },

    data() {
        return {
            currentEvent: this.event[0],
            eventPolls: this.event[0].polls,
            message:'',
            showMessage: false
        }
    },

    methods:{
        uploadAttendees(){
            this.$emit('uploadAttendees');
        },

        createPoll(){
            this.$emit('nnn');
        },

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