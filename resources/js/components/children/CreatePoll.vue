<template>
    <div>

        <!-- Modal: modalPoll -->
        <div class="modal fade right" id="createPoll" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" data-backdrop="false">
            <div class="modal-dialog modal-full-height modal-right modal-notify modal-info" role="document">
                <div class="modal-content">
                    <form action="" method="post" @submit.prevent="editing ? updatePoll(): storePoll()" @keydown="errors.clear($event.target.name)">
                        <!--Header-->
                        <div class="modal-header">
                            <p class="heading lead">Create Poll
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
                            <!-- TITLE -->
                            <div class="col-10 col-md-12 pr-0">

                            <div class="md-form">
                                <input name="title" id="mce-TITLE" v-model="poll.title" type="text" class="form-control required" aria-required="true" required>
                                <label for="mce-TITLE" class="">Title</label>
                                <span class="help text-danger" v-if="errors.has('title')" v-text="errors.get('title')"></span>
                            </div>

                            </div>
                            <!-- SHORT TITLE -->
                            <div class="col-10 col-md-12 pr-0">
                                <div class="md-form">
                                    <input name="short_title" id="mce-SHORTTITLE" v-model="poll.short_title" type="text" class="form-control required" aria-required="true" required>
                                    <label for="mce-SHORTTITLE" class="">Short Title</label>
                                    <span class="help text-danger" v-if="errors.has('short_title')" v-text="errors.get('short_title')"></span>
                                </div>
                            </div>
                            <!-- TYPE -->
                            <div class="col-10 col-md-12 pr-0">
                                <div class="md-formn">
                                    <select name="type" v-model="poll.type" class="mdb-select md-form form-control required" aria-required="true" required>
                                        <option value="" disabled selected>Choose Type</option>
                                        <option value="1">Normal</option>
                                        <option value="2">Multi Candidate</option>
                                    </select>
                                    <span class="help text-danger" v-if="errors.has('type')" v-text="errors.get('type')"></span>
                                </div>
                            </div>
                            <!-- MAX CHOICE -->
                            <div class="col-10 col-md-12 pr-0" v-if="poll.type == 2">
                                <div class="md-form">
                                    <input name="max_candidate" id="mce-MAXCANDIDATE" v-model="poll.max_candidate" type="number" class="form-control">
                                    <label for="mce-MAXCANDIDATE" class="">Max Candidate</label>
                                    <span class="help text-danger" v-if="errors.has('max_candidate')" v-text="errors.get('max_candidate')"></span>
                                </div>
                            </div>
                            <!-- MISC -->
                            <div class="col-10 col-md-12 pr-0">
                                <div class="md-form">
                                    <input name="misc" id="mce-MISC" v-model="poll.misc" type="text" class="form-control">
                                    <label for="mce-MISC" class="">Misc</label>
                                    <span class="help text-danger" v-if="errors.has('misc')" v-text="errors.get('misc')"></span>
                                </div>
                            </div>
                            <!-- MISC1 -->
                            <div class="col-10 col-md-12 pr-0">
                                <div class="md-form">
                                    <input name="misc1" id="mce-MISC1" v-model="poll.misc1" type="text" class="form-control">
                                    <label for="mce-MISC1" class="">Misc 1</label>
                                    <span class="help text-danger" v-if="errors.has('misc1')" v-text="errors.get('misc1')"></span>
                                </div>
                            </div>
                            <!-- MISC2 -->
                            <div class="col-10 col-md-12 pr-0">
                                <div class="md-form">
                                    <input name="misc2" id="mce-MISC2" v-model="poll.misc2" type="text" class="form-control">
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

                        </div>

                        <!--Footer-->
                        <div class="modal-footer justify-content-center">
                            <button type="submit" class="btn btn-primary waves-effect waves-light" v-if="editing">Update
                                <i class="fa fa-paper-plane ml-1"></i>
                            </button>
                            <button type="buton" class="btn btn-primary waves-effect waves-light" :disabled="errors.any()" v-else>Create
                                <i class="fa fa-paper-plane ml-1"></i>
                            </button>
                            <a type="button" class="btn btn-outline-primary waves-effect" data-dismiss="modal">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal: modalpoll -->

    </div>
</template>

<script>

class Errors {
    constructor() {
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

  class Poll {
    constructor(poll) {
      this.id = poll.id || null,
      this.title = poll.title || '',
      this.short_title = poll.short_title || '';
      this.type = poll.type || '';
      this.max_candidate = poll.max_candidate || '';
      this.misc = poll.misc || '',
      this.misc1 = poll.misc1 || '',
      this.misc2 = poll.misc2 || '',
      this.misc3 = poll.misc3 || ''
    }
  }

export default {
    
    mounted() {
        this.$parent.$on('createNewPoll', (eventId) =>{
            this.editing = false;
            this.poll = new Poll({});
            this.poll.event_id = eventId;
            $('#createPoll').modal();
        })
    },

    data() {
        return {
            poll: {},
            errors: new Errors(),
            editing: false,
            
        }
    },

    methods: {

        storePoll() {
            axios.post('/api/poll', this.poll)
            .then( response => {
                this.$parent.$emit('pollCreated', response.data);
                $('#createPoll').modal('hide');
            }).catch((err) => {
                this.errors.record(err.response.data.errors);
            });
        }
    }
}
</script>