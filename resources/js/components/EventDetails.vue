<template>
<div>
    
    <div class="clearfix"></div>
    <!-- DataTales Example -->
    <div v-show="showMessage" class="alert alert-success alert-dismisable fade show" role="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>{{message}}</strong>
    </div>
    <div>
        <button @click="openCloseEvent()"  :class="btnColor+' btn btn-sm'">
            {{event.status ? 'active' : 'inactive'}}
        </button>
    </div>
    <div class="">
    <!-- Nav tabs -->
        <ul class="nav nav-tabs mt-2">
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
                <event-polls :polls="event.polls" :eventId="event.id"></event-polls>
            </div>
            <div class="tab-pane  fade" id="attendees">
                <event-attendees :eventId="event.id"></event-attendees>
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
        this.$on('importQueued', (result) => {
            this.showAlert(result.message, 5000);
        });
    },

    components: {
        "event-polls": require('./children/EventPolls.vue').default,
        "event-attendees": require('./children/EventAttendees.vue').default
    },

    data() {
        return {
            message:'',
            btnColor: this.event.status ? 'btn-success' : 'btn-danger', //sets at page mount
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

        openCloseEvent()
        {
            axios.put('/event/'+this.event.id, {
                'status': Number(!this.event.status)
            })
            .then( response => {
                if (response.status == 200) {
                    this.event.status = response.data.mode;
                    this.event.status == 1 ? this.btnColor ='btn-success' : this.btnColor ='btn-danger';
                    // this.message = response.data.message;
                    // this.showAlert(this.message, 4000)
                }
            })
            .catch(err => console.log(err));
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