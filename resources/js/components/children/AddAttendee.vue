
<template>
    <div>

        <!-- Modal: Attendee -->
        <div class="modal fade right" id="addAttendee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" data-backdrop="false">
            <div class="modal-dialog modal-full-height modal-right modal-notify modal-info" role="document">
                <div class="modal-content">
                    <form action="" method="post" @submit.prevent="editing ? updateAttendee(): storeAttendee()" @keydown="errors.clear($event.target.name)">
                        <!--Header-->
                        <div class="modal-header">
                            <p class="heading lead">Add New Attendee
                            </p>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="white-text">×</span>
                            </button>
                        </div>

                        <!--Body-->
                        <div class="modal-body">
                            <div class="text-center">
                            <!-- <i class="far fa-file-alt fa-4x mb-3 animated rotateIn"></i> -->
                            <p>
                                <strong>Fill in details.</strong>
                            </p>
                            </div>

                            <hr>
                            <!-- NAME -->
                            <div class="col-10 col-md-12 pr-0">
                                <div class="md-form">
                                    <input name="name" id="mce-NAME" v-model="attendee.name" type="text" class="form-control required" aria-required="true" required>
                                    <label for="mce-NAME" class="">Name</label>
                                    <span class="help text-danger" v-if="errors.has('name')" v-text="errors.get('name')"></span>
                                </div>
                            </div>
                            <!-- EMAIL -->
                            <div class="col-10 col-md-12 pr-0">
                                <div class="md-form">
                                    <input name="email" id="mce-EMAIL" v-model="attendee.email" type="email" class="form-control">
                                    <label for="mce-EMAIL" class="">Email</label>
                                    <span class="help text-danger" v-if="errors.has('email')" v-text="errors.get('email')"></span>
                                </div>
                            </div>
                            <!-- MOBIILE -->
                            <div class="col-10 col-md-12 pr-0">
                                <div class="md-form">
                                    <input name="mobile" id="mce-MOILE" v-model="attendee.mobile" type="number" class="form-control">
                                    <label for="mce-MOBILE" class="">Mobile</label>
                                    <span class="help text-danger" v-if="errors.has('mobile')" v-text="errors.get('mobile')"></span>
                                </div>
                            </div>
                            <!-- MISC -->
                            <div class="col-10 col-md-12 pr-0">
                                <div class="md-form">
                                    <input name="misc" id="mce-MISC" v-model="attendee.misc" type="text" class="form-control">
                                    <label for="mce-MISC" class="">Misc</label>
                                    <span class="help text-danger" v-if="errors.has('misc')" v-text="errors.get('misc')"></span>
                                </div>
                            </div>
                            <!-- MISC1 -->
                            <div class="col-10 col-md-12 pr-0">
                                <div class="md-form">
                                    <input name="misc1" id="mce-MISC1" v-model="attendee.misc1" type="text" class="form-control">
                                    <label for="mce-MISC1" class="">Misc 1</label>
                                    <span class="help text-danger" v-if="errors.has('misc1')" v-text="errors.get('misc1')"></span>
                                </div>
                            </div>
                            <!-- MISC2 -->
                            <div class="col-10 col-md-12 pr-0">
                                <div class="md-form">
                                    <input name="misc2" id="mce-MISC2" v-model="attendee.misc2" type="text" class="form-control">
                                    <label for="mce-MISC2" class="">Misc 2</label>
                                    <span class="help text-danger" v-if="errors.has('misc2')" v-text="errors.get('misc2')"></span>
                                </div>
                            </div>
                            <!-- MISC3 -->
                            <div class="col-10 col-md-12 pr-0">
                                <div class="md-form">
                                    <input name="misc3" id="mce-MISC3" v-model="attendee.misc3" type="text" class="form-control">
                                    <label for="mce-MISC3" class="">Misc 3</label>
                                    <span class="help text-danger" v-if="errors.has('misc3')" v-text="errors.get('misc3')"></span>
                                </div>
                            </div>
                            <!-- MISC4 -->
                            <div class="col-10 col-md-12 pr-0">
                                <div class="md-form">
                                    <input name="misc4" id="mce-MISC4" v-model="attendee.misc4" type="text" class="form-control">
                                    <label for="mce-MISC4" class="">Misc 4</label>
                                    <span class="help text-danger" v-if="errors.has('misc4')" v-text="errors.get('misc4')"></span>
                                </div>
                            </div>
                            <!-- MISC5 -->
                            <div class="col-10 col-md-12 pr-0">
                                <div class="md-form">
                                    <input name="misc5" id="mce-MISC5" v-model="attendee.misc5" type="text" class="form-control">
                                    <label for="mce-MISC5" class="">Misc 5</label>
                                    <span class="help text-danger" v-if="errors.has('misc5')" v-text="errors.get('misc5')"></span>
                                </div>
                            </div>

                        </div>

                        <!--Footer-->
                        <div class="modal-footer justify-content-center">
                            <button type="submit" class="btn btn-primary waves-effect waves-light" v-if="editing">Update
                                <i class="fa fa-paper-plane ml-1"></i>
                            </button>
                            <button type="buton" class="btn btn-primary waves-effect waves-light" :disabled="errors.any()" v-else>Add
                                <i class="fa fa-paper-plane ml-1"></i>
                            </button>
                            <a type="button" class="btn btn-outline-primary waves-effect" data-dismiss="modal">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal: Attendee -->

    </div>
</template>

<script>
class Errors 
{
    constructor() 
    {
      this.errors = {};
    }

    any() {
      return Object.keys(this.errors).length > 0;
    }

    get(field) {
      if (this.errors[field]) {
        return this.errors[field][0];
      }
    }

    has(field) {
      return this.errors.hasOwnProperty(field)
    }

    record(errors){
      this.errors = errors;
    }

    clear(field) {
      delete this.errors[field];
    }

  }

class Attendee 
{
    constructor(attendee)
    {
        this.id = attendee.id || null,
        this.name = attendee.name || '',
        this.email = attendee.email || '';
        this.mobile = attendee.mobile || '',
        this.misc = attendee.misc || '',
        this.misc1 = attendee.misc1 || '',
        this.misc2 = attendee.misc2 || '',
        this.misc3 = attendee.misc3 || '',
        this.misc4 = attendee.misc4 || ''
        this.misc5 = attendee.misc5 || ''
    }
}

export default {

    props: ['eventId'],
    
    mounted() {
        this.$parent.$on('addNewAttendee', (eventId) => {
            this.editing = false;
            this.attendee = new Attendee({});
            this.attendee.event_id = eventId;
            $('#addAttendee').modal();

        })
    },

    data() {
        return {
            attendee: {},
            poll: {},
            errors: new Errors(),
            editing: false
        }
    },

    methods: {
        storeAttendee()
        {
            axios.post('/api/attendee', this.attendee)
            .then(response => {
                this.$parent.$emit('attendeeCreated', (response.data));
                $('#addAttendee').modal('hide');
            }).catch( err => {
                this.errors.record(err.response.data.errors);
            });
        }
    }
}
</script>