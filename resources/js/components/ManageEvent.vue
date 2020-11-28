<template>
    <div>
        <button class="btn btn-sm btn-primary mb-2" @click="createEvent()">New Event</button>
        
        <div class="clearfix"></div>
        <!-- DataTales Example -->
        <div v-show="showMessage" class="alert alert-success alert-dismisable fade show" role="alert">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>{{message}}</strong>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All Events</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable-event" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Company</th>
                                <th>Created by</th>
                                <th>Action</th>                 
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>SN</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Company</th>
                                <th>Created by</th>
                                <th>Action</th>  
                            </tr>
                        </tfoot>
                        <tbody>
                            <tr v-for="(event, index) in allEvents" :key='index'>
                                <td>{{index + 1}}</td>
                                <td class='font-weight-bold'><a :href="'event/'+event.id">{{event.title}}</a></td>
                                <td>{{event.status === 0 ? 'CLOSE' : 'OPEN'}}</td>
                                <td>{{event.company.short_name}}</td>
                                <td>{{event.user_id}}</td>
                                <td>
                                    <button @click="editEvent(event)"  class='btn btn-outline-warning btn-sm'><i class="text-yellow fas fa-edit"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
            <create-event></create-event>
    </div>
</template>

<script>
export default {
    props: ['events', 'companies'],

    mounted() {
        
        this.$on('eventCreated', (event) => {
            this.showAlert('Event created successfully.', 4000);
            this.allEvents.push(event);
        })
    },

    components: {
        "create-event": require('./children/CreateEvent.vue').default
    },

    data() {
        return {
            allEvents: this.events,
            message:'',
            showMessage: false
        }
    },

    methods:{
        createEvent(){
            this.$emit('createNewEvent', this.companies);
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