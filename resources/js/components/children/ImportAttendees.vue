
<template>
    <div>

        <!-- Modal: Attendee Import -->
        <div class="modal fade right" id="importAttendees" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" data-backdrop="false">
            <div class="modal-dialog modal-full-height modal-right modal-notify modal-info" role="document">
                <div class="modal-content">
                    <form action="" method="post" @change="importAttendees" @submit.prevent="importAttendees" @keydown="errors.clear($event.target.name)">
                        <!--Header-->
                        <div class="modal-header">
                            <p class="heading lead">Import Attendees
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
                            <!-- FILE -->
                            <div class="col-10 col-md-12 pr-0">
                                <label for="mce-FILE" class="">File</label><br>
                                <span class="help text-danger" v-if="errors.has('file')" v-text="errors.get('file')"></span>
                                <div class="md-form">
                                    <input name="file" id="mce-FILE" type="file" class="form-control required" aria-required="true" required>
                                </div>
                            </div>

                        </div>

                        <!--Footer-->
                        <div class="modal-footer justify-content-center">
                            <button type="buton" class="btn btn-primary waves-effect waves-light" :disabled="errors.any()">Import
                                <i class="fa fa-paper-plane ml-1"></i>
                            </button>
                            <a type="button" class="btn btn-outline-primary waves-effect" data-dismiss="modal">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal: Attendee Import -->

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

export default {

    props: ['eventId'],

    mounted(){
        this.$parent.$on('importAttendees', eventId => {
            $('#importAttendees').modal();
        })
    },

    data() {
        return {
            file: null,
            errors: new Errors()
        }
    },

    methods: {
        importAttendees(event)
        {
            this.file = event.target.files[0];
            const data = new FormData();
            data.append('file', this.file);
            data.append('event_id', this.eventId)

            axios.post('/api/attendee/import', data)
            .then(response => {
                if (response.status == 200) {
                    this.$parent.$emit('importQueued', (response.data));
                    $('#importAttendees').modal('hide');   
                }
            }).catch( err => {
                this.errors.record(err.response.data.errors);
            });
        }
    }
}
</script>