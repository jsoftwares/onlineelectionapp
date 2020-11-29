
<template>
    <div>

        <!-- Modal: Candidate -->
        <div class="modal fade right" id="addCandidate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" data-backdrop="false">
            <div class="modal-dialog modal-full-height modal-right modal-notify modal-info" role="document">
                <div class="modal-content">
                    <form action="" method="post" @submit.prevent="editing ? updateCandidate(): storeCandidate()" @keydown="errors.clear($event.target.name)">
                        <!--Header-->
                        <div class="modal-header">
                            <p class="heading lead">Add New Candidate for {{poll.title}}
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
                                    <input name="name" id="mce-NAME" v-model="candidate.name" type="text" class="form-control required" aria-required="true" required>
                                    <label for="mce-NAME" class="">Name</label>
                                    <span class="help text-danger" v-if="errors.has('name')" v-text="errors.get('name')"></span>
                                </div>
                            </div>
                            <!-- EMAIL -->
                            <div class="col-10 col-md-12 pr-0">
                                <div class="md-form">
                                    <input name="email" id="mce-EMAIL" v-model="candidate.email" type="email" class="form-control">
                                    <label for="mce-EMAIL" class="">Email</label>
                                    <span class="help text-danger" v-if="errors.has('email')" v-text="errors.get('email')"></span>
                                </div>
                            </div>
                            <!-- MOBIILE -->
                            <div class="col-10 col-md-12 pr-0">
                                <div class="md-form">
                                    <input name="mobile" id="mce-MOILE" v-model="candidate.mobile" type="number" class="form-control">
                                    <label for="mce-MOBILE" class="">Mobile</label>
                                    <span class="help text-danger" v-if="errors.has('mobile')" v-text="errors.get('mobile')"></span>
                                </div>
                            </div>
                            <!-- MISC -->
                            <div class="col-10 col-md-12 pr-0">
                                <div class="md-form">
                                    <input name="misc" id="mce-MISC" v-model="candidate.misc" type="text" class="form-control">
                                    <label for="mce-MISC" class="">Misc</label>
                                    <span class="help text-danger" v-if="errors.has('misc')" v-text="errors.get('misc')"></span>
                                </div>
                            </div>
                            <!-- MISC1 -->
                            <div class="col-10 col-md-12 pr-0">
                                <div class="md-form">
                                    <input name="misc1" id="mce-MISC1" v-model="candidate.misc1" type="text" class="form-control">
                                    <label for="mce-MISC1" class="">Misc 1</label>
                                    <span class="help text-danger" v-if="errors.has('misc1')" v-text="errors.get('misc1')"></span>
                                </div>
                            </div>
                            <!-- MISC2 -->
                            <div class="col-10 col-md-12 pr-0">
                                <div class="md-form">
                                    <input name="misc2" id="mce-MISC2" v-model="candidate.misc2" type="text" class="form-control">
                                    <label for="mce-MISC2" class="">Misc 2</label>
                                    <span class="help text-danger" v-if="errors.has('misc2')" v-text="errors.get('misc2')"></span>
                                </div>
                            </div>
                            <!-- MISC3 -->
                            <div class="col-10 col-md-12 pr-0">
                                <div class="md-form">
                                    <input name="misc3" id="mce-MISC3" v-model="poll.misc3" type="text" class="form-control">
                                    <label for="mce-MISC3" class="">Misc 3</label>
                                    <span class="help text-danger" v-if="errors.has('misc3')" v-text="errors.get('misc3')"></span>
                                </div>
                            </div>
                            <!-- MISC3 -->
                            <div class="col-10 col-md-12 pr-0">
                                <div class="md-form">
                                    <input name="misc4" id="mce-MISC4" v-model="poll.misc4" type="text" class="form-control">
                                    <label for="mce-MISC4" class="">Misc 4</label>
                                    <span class="help text-danger" v-if="errors.has('misc4')" v-text="errors.get('misc4')"></span>
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
        <!-- Modal: Candidate -->

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
class Candidate 
{
    constructor(candidate)
    {
        this.id = candidate.id || null,
        this.name = candidate.name || '',
        this.email = candidate.email || '';
        this.mobile = candidate.mobile || '',
        this.misc = candidate.misc || '',
        this.misc1 = candidate.misc1 || '',
        this.misc2 = candidate.misc2 || '',
        this.misc3 = candidate.misc3 || '',
        this.misc4 = candidate.misc4 || ''
    }
}

export default {
    
    mounted() {
        this.$parent.$on('addNewCandidate', (poll) => {
            console.log(poll);
            this.editing = false;
            this.poll = poll;
            this.candidate = new Candidate({});
            this.candidate.poll_id = poll.id;
            $('#addCandidate').modal();

        })
    },

    data() {
        return {
            candidate: {},
            poll: {},
            errors: new Errors(),
            editing: false
        }
    },

    methods: {
        storeCandidate()
        {
            axios.post('/api/candidate', this.candidate)
            .then(response => {
                this.$parent.$emit('candidateCreated', (response.data));
                $('#addCandidate').modal('hide');
            }).catch( err => {
                this.errors.record(err.response.data.errors);
            });
        }
    }
}
</script>