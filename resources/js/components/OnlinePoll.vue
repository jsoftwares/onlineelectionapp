<template>
    <div class="container-fluid" style="font-family:'century gothic'">
        <!-- LOGIN AREA -->
        <div class="row justify-content-center mb-5" v-show="!grantAccess">
            <div class="col-md-8 col-sm-8">

                <!-- Notification -->
                <transition name="fade">
                    <div v-show="flashAlert" class="alert alert-danger alert-dismisable fade show" role="alert">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>{{this.message}}</strong>
                    </div>
                </transition>

                <!-- Authentication -->
                <div class="card card-default">
                    <div class="card-header bg-primary text-white"><h5>Welcome! Enter token/code to continue</h5></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Enter Token</label>
                            <input type="text" class="form-control" v-model="token" autofocus>
                        </div>
                        <div class="form-group">
                            <button @click="accessChecker" class="btn btn-block btn-primary font-weight-bold text-white">Continue...</button>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

        <!-- ATTENDEE Details -->
        <div class="row mb-4" v-show="grantAccess">
            <!-- <span class="float-right"> -->
                <button @click.prevent="logout" class="btn btn-primary text-white mb-2 float-right">
                    <i class="fas fa-sign-out-alt"></i> Logout</button>
            <!-- </span> -->
            
            <ul class="list-group justify-content-center col-md-12 col-sm-12">
                <li class="list-group-item">
                    <strong class="mr-4">WELCOME: {{this.attendee.name}}</strong> || 
                    <strong class="mr-4 ml-4">MOBILE: {{this.attendee.mobile}}</strong> || 
                    <strong class="ml-4">EMAIL: {{this.attendee.email}} </strong>
                </li>
            </ul>
        </div>

        <!-- POLL Area -->
        <div class="row justify-content-center" v-show="grantAccess">
            <!-- Poll Area -->
            <div class="col-md-12 col-sm-12" v-if="showPoll">
                <!-- Notification -->
                <!-- <transition name="fade"> -->
                    <div v-show="flashAlert" class="alert alert-success alert-dismisable fade show" role="alert">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>{{this.message}}</strong>
                    </div>
                <!-- </transition> -->

                <div class="card card-default">
                    <div class="card-header bg-primary text-white"><h5>{{event.title}}</h5></div>

                    <div class="card-body">

                        <!-- <br> -->

                        <!-- Actual Poll Display Starts-->
                        <div id="accordion">
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            <h5>INSTRUCTIONS</h5>
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
                                <div class="card-body">
                                   <p>Kindy click the title of each poll below to see its candidates, then click the <strong>"CAST VOTE"</strong> button next to your candidate of choice
                                        to cast your vote for that candidate. Note that you can only vote for one candidate per poll, clicking another button within
                                        the same poll will change your previous vote.
                                   </p>
                                </div>
                                </div>
                            </div>
                            <div class="card" v-for="(poll, index) in event.polls" :key="index">
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" data-toggle="collapse" v-bind:data-target="'#collapse'+poll.id" aria-expanded="true" aria-controls="collapseOne">
                                        Vote for {{poll.title}}
                                        </button>
                                    </h5>
                                </div>

                                <div v-bind:id="'collapse'+poll.id" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                    
                                    <div class="card-header text-white" v-show="flashAlert">
                                        <!-- <div v-show="flashAlert" :class="'alert alert-dismisable fade show '+alertType" role="alert">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            <strong>{{this.message}}</strong>
                                        </div> -->
                                    </div>

                                    <div class="card-body row">
                                        <!-- Candidates Start-->
                                                <div class="media mb-4 mr-4" v-for="(candidate, index) in poll.candidates" :key="index">
                                                    <div class="media-left">
                                                        <img src="/img/img_avatar1.png" class="media-object" style="width:64px">
                                                    </div>
                                                    <div class="media-body">
                                                        <h6 class="media-heading">{{candidate.name}}</h6>
                                                        <p><button class="btn btn-sm btn-primary mb-2" @click="castVote(poll, candidate.id)">Cast Vote</button></p>
                                                    </div>
                                                </div>
                                            <!-- Candidate Stop -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Actual Poll Display Ends -->
                       

                    </div>
                </div>
            </div>
            
            <!-- If No Pool is active OR Shareholder is not eligile to vote online -->
            <div class="col-md-7 col-sm-7" v-else>
                <div class="card-header bg-danger text-white"><h5 class="font-weight-bold">PLEASE DO NOT LEAVE OR REFRESH THIS PAGE</h5></div>
                <div class="card card-default">
                    <div v-if="true" class="card-body font-weight-bold">
                        <p>There are no ongoing polls currently, Please remain on this page for the next resolution.</p>
                        <p>Click any of the button to vote once the resolution displays. You can also update your vote by clicking another button. </p>
                    </div>
                    <div v-else class="card-body text-danger font-weight-bold">
                        <p>You can not cast your vote(s) online either because you have voted through PROXY or USSD.</p>
                        <p>You can still use the question section to ask your questions. Thank you</p>
                    </div>
                    
                </div>
            </div>

             <!-- Ask Questions -->
            <!-- MOVE TO MODAL -->

        </div>

       
    </div>
</template>

<script>

export default {
    
    props: ['event'],

    mounted() {
        console.log(this.event.id);
        if (localStorage.exchange_confd) {
            this.token = localStorage.exchange_confd.split('_')[1];
            this.accessChecker();   
        }
    },

    data()
    {
        return {
            'attendee': {},
            'token': '',
            'onlineEntries': '',
            'grantAccess': false,
            'showPoll': true,
            'message': '',
            'flashAlert': false,
            'alertType': '',
            'questionAlert': '',
            'baseURL': process.env.MIX_APP_URL,
            'lsKey': 'conf'+this.event.uid
        }
    },

    methods: {
        castVote(poll, candidateId)
        {
            axios.post('/api/vote', {
                'poll_uid': poll.uid,
                'candidate': candidateId,
                'attendee_id': this.attendee.id
            })
            .then( response => {
                if (response.data.status === 200) {
                    this.showAlert(response.data.message, 'alert-success', 3000);
                }
                else{
                    this.showAlert(response.data.message, 'alert-danger', 3000);
                }
            }).catch( err => console.log('Something went wrong'));
        },

        showAlert(message, className, time){
            this.alertType = className;
            this.message = message;
            this.flashAlert = true;
            setTimeout(() => {
                this.flashAlert = false;
                this.alertType = '';
                this.message = '';
            }, time);
        },

        authenticateAttendee(){},

        question(){},
        accessChecker(){

            if (this.token != '') {
                axios.post('/attendee/login', {
                    'event_id':this.event.id, 
                    'token':this.token
                })
                .then(response=>{

                    if (response.data.status == 200) {
                        this.attendee = response.data.attendee;
                        this.onlineEntries = response.data.attendee.onlineSessionKey;
                        if (this.onlineEntries != '') {
                            localStorage.exchange_confd = this.onlineEntries;
                            this.grantAccess = true;
                            //store data in local storage and in Cache
                            // const userKey = this.attendee.uid+'_'+this.attendee.token; exchange_confd15fbcd0b21e634
                            
                            // STORE KEY
                            // HTTP.post('/api/v1/attendee/create-session', {
                            //     'key': userKey,
                            //     'attendee_id': this.attendee.id,
                            //     'token': this.attendee.token,

                            // }).then( response => {
                            //     localStorage.configx = userKey;
                            //     this.onlinekey = response.data.key;
                            //     this.grantAccess = true;
                                
                            // }).catch(err => console.log(err));
                            
                        }else{
                            if (this.onlineEntries == localStorage.exchange_confd) {
                                this.grantAccess = true;
                            }else{
                                this.grantAccess = false;
                            this.showAlert('Oops! you can only login from one device, logout from other device inorder to login here.', 'alert-danger', 8000);
                            }
                        }
                    }else if(response.data.status == 409){
                        this.showAlert(response.data.message, 'alert-danger', 10000);
                    }else{
                        this.showAlert(response.data.message, 'alert-danger', 10000);
                    }
                    
                }).catch( err=> console.log(err))
                
            }else{
                this.showAlert('Please enter your token to continue.', 'alert-danger', 10000);
            }
                
            },

            logout(){
                axios.post('/attendee/logout', {
                    'attendee': this.attendee.id,
                    'event_id': this.event.id
                })
                .then(()=>{
                    localStorage.removeItem('exchange_confd');
                    
                    this.grantAccess = false;
                    this.attendee = null;
                    location.reload();
                })
            },
            
    }
}
</script>