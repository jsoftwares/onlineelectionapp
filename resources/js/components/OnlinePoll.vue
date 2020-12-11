<template>
    <div class="container-fluid"  style="font-family:'century gothic'">
        <!-- LOGIN AREA -->
        <div class="row justify-content-center mb-5" v-show="!grantAccess">
            <div class="col-md-8 col-sm-8">

                <!-- Notification -->
                <!-- <transition name="fade"> -->
                    <div v-show="flashAlert" :class="alertType + ' alert alert-dismisable fade show'" role="alert">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>{{this.message}}</strong>
                    </div>
                <!-- </transition> -->

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
                <button @click.prevent="logout" class="btn btn-danger text-white mb-2 float-right">
                    <i class="fas fa-sign-out-alt"></i> Logout</button>
            <!-- </span> -->
            
            <ul class="list-group justify-content-center col-md-12 col-sm-12">
                <li class="list-group-item">
                    <strong class="mr-4">WELCOME: {{attendee.name}}</strong> || 
                    <strong class="mr-4 ml-4">MOBILE: {{attendee.mobile}}</strong> || 
                </li>
            </ul>
        </div>

        <!-- POLL Area -->
        <div class="row justify-content-center" v-show="grantAccess">
            <!-- Poll Area Start-->
            <div class="col-md-12 col-sm-12" v-if="showPoll">
                <!-- Notification -->
                <!-- <transition name="fade"> -->
                    <!-- <div v-show="flashAlert" :class="alertType + ' alert alert-dismisable fade show'" role="alert">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>{{this.message}}</strong>
                    </div> -->
                <!-- </transition> -->

                <div class="card card-default col-md-12 col-sm-12">
                    <div class="card-header bg-success"><h5 class=" text-white font-weight-bold">{{event.title}}</h5></div>

                    <div class="card-body">

                        <!-- <br> -->

                        <!-- Actual Poll Display Starts-->
                        <div id="accordion">
                            <div class="card">
                                <div class="card-header p-0" id="headingTwo">
                                    <h5 class="m-0 p-0">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        <span class="font-weight-bold text-danger h5">INSTRUCTIONS</span>
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseTwo" class="collapse show text-justify" aria-labelledby="headingTwo" data-parent="#accordion">
                                <div class="card-body font-weight-bold text-danger">
                                   <p>Kindy click the title of each poll below to see its candidates, then click the "CAST VOTE" button next to your candidate of choice
                                        to cast your vote for that candidate. Note that you can only vote for one candidate per poll, clicking another button within
                                        the same poll will change your previous vote. After voting, kindly click the LOGOUT button at the top of this page to exit. Thank you.
                                   </p>
                                </div>
                                </div>
                            </div>
                            <div class="card" v-for="(poll, index) in event.polls" :key="index">
                                <div class="card-header p-0" id="headingOne">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link font-weight-bold" data-toggle="collapse" v-bind:data-target="'#collapse'+poll.id" aria-expanded="true" aria-controls="collapseOne">
                                        Vote for {{poll.title}}
                                        </button>
                                    </h5>
                                </div>

                                <div v-bind:id="'collapse'+poll.id" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">

                                    <div v-show="flashAlert" :class="alertType+ ' col-md-12 cols-sm-12 alert alert-dismisable fade show'" role="alert">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>{{message}}</strong>
                                    </div>
                            
                                    <div class="card-body row" v-if="poll.type==1">
                                        <!-- Candidates Start-->
                                                <div class="media mb-4 mr-4" v-for="(candidate, index) in poll.candidates" :key="index">
                                                    <div class="media-left">
                                                        <img src="/img/img_avatar1.png" class="media-object" style="width:64px">
                                                    </div>
                                                    <div class="media-body">
                                                        <h6 class="media-heading font-weight-bold">{{candidate.name}}</h6>
                                                        <button class="btn btn-sm btn-success mb-2" @click="castVote(poll, candidate.id, event)" :disabled="btnText=='Sending...' || disableBtn">
                                                            <div v-show="btnText=='Sending...'" class="spinner-border spinner-border-sm" role="status">
                                                                <span class="sr-only">Loading...</span>
                                                            </div>
                                                            {{btnText}}
                                                        </button>
                                                    </div>
                                                </div>
                                                
                                            <!-- Candidate Stop -->
                                    </div>
                                    <!-- CHOOSING MULTIPLE CANDIDATE -->
                                    <div class="card-body" v-else>
                                        <!-- Candidates Start-->
                                        <h6 class="text-danger mb-4">You may select at most {{poll.max_candidate}} candidates from below.</h6>
                                            <form @submit.prevent="multiCandidateVote(poll)" action="" method="post" class="row">
                                                <div class="media mb-4 mr-4" v-for="(candidate, index) in poll.candidates" :key="index">                                              
                                                    <div class="">
                                                        <!-- <label :for="'candidate'+candidate.id"> -->
                                                            <div class="media-left">
                                                                <img src="/img/img_avatar1.png" class="media-object" style="width:64px">
                                                            </div>
                                                        <!-- </label> -->
                                                            <div class="media-body">
                                                                <input type="checkbox" @change="maxCandidate($event, poll.max_candidate)" v-model="multiChoicePoll.checkedCandidates" :name="candidate.id" :value="candidate.id" class="boxes">
                                                            </div>
                                                            <h6 class="media-heading font-weight-bold">{{candidate.name}}</h6>
                                                
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <button class="btn btn-sm btn-success mb-2" type="submit" :disabled="btnText=='Sending...' || disableBtn">
                                                        <div v-show="btnText=='Sending...'" class="spinner-border spinner-border-sm" role="status">
                                                            <span class="sr-only">Loading...</span>
                                                        </div>
                                                        {{btnText}}
                                                    </button>
                                                </div>
                                            </form>
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
import {HTTP} from '../custom';

export default {
    
    props: ['event'],

    mounted() {
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
            'lsKey': 'conf'+this.event.uid,
            'btnText': 'CAST VOTE',
            'disableBtn': false,
            'multiChoicePoll': {
                'checkedCandidates': Array()
            }
        }
    },

    methods: {
        castVote(poll, candidateId, event)
        {
            this.btnText = 'Sending...';
            HTTP.post('/api/vote', {
                'poll_uid': poll.uid,
                'candidate': candidateId,
                'applc': this.attendee.uid,
                'misc': this.event.uid+'_'+this.event.id
            })
            .then( response => {
                if (response.data.status === 200) {
                    this.showAlert(response.data.message, 'alert-success', 4000);
                    this.btnText = 'CAST VOTE';
                }
                else{
                    this.showAlert(response.data.message, 'alert-danger', 4000);
                }
            }).catch( err => console.log('Something went wrong'));
        },

        multiCandidateVote(poll)
        {
            if (this.multiChoicePoll.checkedCandidates.length == 0 || this.multiChoicePoll.checkedCandidates.length > poll.max_candidate) {
                this.showAlert('Sorry, you may select at most '+poll.max_candidate+' candidates.', 'alert-danger', 5000);
            }else{
                this.btnText = 'Sending...';
                const data = new FormData();
                data.append('candidates', this.multiChoicePoll.checkedCandidates);
                data.append('poll_uid', poll.uid);
                data.append('applc', this.attendee.uid,);
                data.append('misc', this.event.uid+'_'+this.event.id);
                HTTP.post('/api/vote/multiple', data)
                .then(response => {
                    if (response.status == 200) {
                        this.showAlert(response.data.message, 'alert-success', 5000);
                        this.btnText = 'CAST VOTE';
                    }else{
                        if(response.data.status == 403){
                            this.btnText = 'CAST VOTE';
                            this.showAlert(response.data.message, 'alert-danger', 5000);
                            this.logout();
                        }else{
                            this.btnText = 'CAST VOTE';
                            this.showAlert(response.data.message, 'alert-danger', 5000);
                        }
                    }
                    
                })
                .catch( err => console.log(err));
            }
            
        },

        maxCandidate(e, pollMaxCandidate){
            const checkboxes = document.getElementsByClassName('boxes');
                if (this.multiChoicePoll.checkedCandidates.length > pollMaxCandidate) {
                    this.disableBtn = true;
                    this.showAlert('Sorry, you may select at most '+pollMaxCandidate+' candidates.', 'alert-danger', 5000);
                }else{
                    this.disableBtn = false;
                }

            
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
                HTTP.post('/api/attendee/login', {
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
                    }else if(response.data.status == 404){
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
            HTTP.post('/api/attendee/logout', {
                'attendee': this.token, //we're not sending ID in Attendee Resource, so we use token which another unique field in votesessions 
                'event_id': this.event.id
            })
            .then(response =>{
                console.log(response.status);
                if (response.status == 200) {
                    localStorage.removeItem('exchange_confd');
                    
                    this.grantAccess = false;
                    this.attendee = null;
                    location.reload();
                }else{
                    this.showAlert(response.data.message, 'alert-danger', 10000);
                }
                
            })
        },
            
    }
}
</script>