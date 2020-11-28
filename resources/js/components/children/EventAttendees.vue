<template>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <h6 class="m-0 font-weight-bold text-primary col-md-8">All Attendees</h6>
                
                <!-- Start Add Attendees -->
                <div class="btn-group float-right col-md-4" role="group" aria-label="Button group with nested dropdown">
                    <div class="btn-group col-md-12" role="group">
                        <button id="btnGroupDrop1" type="button" class="d-none d-sm-inline-block mr-3 btn btn-sm btn-primary shadow-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-users fa-sm text-white-50"></i> Add Attendees
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <a href="/company" class="d-none d-sm-inline-block dropdown-item shadow-sm"> Import Attendees</a>
                            <a href="#" @click.prevent="addAttendee()" class="d-none d-sm-inline-block dropdown-item shadow-sm"> Single Attendee</a>
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
                            <td>{{attendee.email}}</td>
                            <td>
                                <button @click="editAttendee(attendee)"  class='btn btn-outline-warning btn-sm'><i class="text-yellow fas fa-edit"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <add-attendee :eventId="eventId"></add-attendee>
    </div>

</template>

<script>
import AddAttendee from './AddAttendee.vue'
export default {

    mounted() {
        this.$on('attendeeCreated', data => {
            this.allAttendees.push(data.attendee);
            this.$parent.$emit('attendeeCreated');
        });

        this.loadAttendees();
    },
  components: { AddAttendee },
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

        loadAttendees(){
            axios.post('/api/event/attendees', {'event_id': this.eventId})
            .then(response => {
                if (response.data.status === 200) {
                    this.allAttendees = response.data.attendees;
                }
            })
            .catch( err => console.log('Attendees not loaded'));
        }

    }
}
</script>