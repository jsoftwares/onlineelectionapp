<template>
<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <!-- <div class="row">
                <h6 class="m-0 font-weight-bold text-primary col-md-9">All Polls</h6>
                <button class="btn btn-sm btn-primary m-0 float-right col-md-3" @click="createPoll()">New Poll</button>
            </div> -->
            <div class="row">
                <h6 class="m-0 font-weight-bold text-primary col-md-9">All Attendees</h6>
                
                <!-- Start Add Attendees -->
                <div class="btn-group float-right col-md-3 p-0" role="group" aria-label="Button group with nested dropdown">
                    <div class="btn-group col-md-12 col-sm-12 p-0" role="group">
                        <button id="btnGroupDrop2" type="button" class="d-none d-sm-inline-block btn btn-sm btn-primary m-0 shadow-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-users fa-sm text-white-50"></i> Manage Attendees
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop2">
                            <a href="#" @click.prevent="importAttendees()" class="d-none d-sm-inline-block dropdown-item shadow-sm"> Import Attendees</a>
                            <a href="#" @click.prevent="addAttendee()" class="d-none d-sm-inline-block dropdown-item shadow-sm"> Single Attendee</a>
                            <a href="#" @click.prevent="GenDispToken()" class="d-none d-sm-inline-block dropdown-item shadow-sm"> Send Tokens</a>
                        </div>
                    </div>
                </div>
                <!-- End Add Attendees -->
            </div>
            

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Name</th>
                            <th>Token</th>
                            <th>Email</th>
                            <th>Action</th>                  
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>SN</th>
                            <th>Name</th>
                            <th>Token</th>
                            <th>Email</th>
                            <th>Action</th> 
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr v-for="(attendee, index) in allAttendees" :key="index">
                            <td>{{index + 1}}</td>
                            <td class='font-weight-bold'>{{attendee.name}}</td>
                            <td>{{attendee.token}}</td>
                            <td>{{attendee.mobile}}</td>
                            <td>
                                <button @click="editAttendee(attendee)"  class='btn btn-outline-warning btn-sm'><i class="text-yellow fas fa-edit"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <add-attendee :eventId="eventId"></add-attendee>
        <import-attendees :eventId="eventId"></import-attendees>
    </div>
</div>
</template>

<script>
import AddAttendee from './AddAttendee.vue'
import ImportAttendees from './ImportAttendees.vue'
export default {

    mounted() {
        this.$on('attendeeCreated', data => {
            this.allAttendees.push(data.attendee);
            this.$parent.$emit('attendeeCreated', );
        });

        this.$on('importQueued', result => {
            this.$parent.$emit('importQueued', result);
        })

        this.loadAttendees();
    },
  components: { AddAttendee, ImportAttendees },
    props: ['eventId'],

    data() {
        return{
            allAttendees: []
        }
    },

    methods: {
        addAttendee(){
            this.$emit('addNewAttendee', this.eventId);
        },

        importAttendees()
        {
            this.$emit('importAttendees', this.eventId);
        },

        loadAttendees(){
            axios.post('/api/event/attendees', {'event_id': this.eventId})
            .then(response => {
                if (response.data.status === 200) {
                    this.allAttendees = response.data.attendees;
                }
            })
            .catch( err => console.log('Attendees not loaded'));
        },

        GenDispToken()
        {
            axios.post('/event/sendtoken', {'event_id': this.eventId})
            .then(response => {
                if (response.data.status === 200) {
                    console.log('Successful');
                }
            })
            .catch( err => console.log('Attendees not loaded'));
        }

    }
}
</script>