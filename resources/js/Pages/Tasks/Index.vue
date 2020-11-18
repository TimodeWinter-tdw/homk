<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Shopping list
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <flash-messages :error="flash.error" :success="flash.success"></flash-messages>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">

                        <FullCalendar :options="calendarOptions"></FullCalendar>

                    </div>
                </div>
            </div>
        </div>

        <jet-dialog-modal :show="modal.show" @close="modal.show = false">
            <template #title>
                <span v-if="modal.event_by_user === user_id || modal.event_by_user === null">Create a new calendar event</span>
                <span v-else>View calendar event</span>
            </template>

            <template v-if="modal.event_by_user == user_id || modal.event_by_user === null" #content>
                <jet-label for="color" value="Color" />
                <v-swatches id="color" ref="color" v-model="form.color"></v-swatches>
                <jet-input-error :message="form.error('color')" class="mt-2" />

                <jet-label for="title" value="Title" />
                <jet-input id="title" type="text" class="mt-1 block w-full" v-model="form.title" ref="title" autocomplete="title" />
                <jet-input-error :message="form.error('title')" class="mt-2" />

                <jet-label for="description" value="Description" />
                <jet-input id="description" type="text" class="mt-1 block w-full" v-model="form.description" ref="description" autocomplete="description" />
                <jet-input-error :message="form.error('description')" class="mt-2" />

                <jet-label for="joinable" value="Joinable" />
                <input id="joinable" type="checkbox" class="mt-1 block" v-model="form.joinable" ref="joinable" autocomplete="joinable" />
                <jet-input-error :message="form.error('joinable')" class="mt-2" />

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <jet-label for="start" value="Start" />
                        <v-date-time id="start" type="datetime" class="mt-1 block w-full" v-model="form.start" ref="start" autocomplete="start" mode="dateTime" is24hr>
                            <template v-slot="{ inputValue, inputEvents }">
                                <input
                                    class="px-2 py-1 border rounded focus:outline-none focus:border-blue-300"
                                    :value="inputValue"
                                    v-on="inputEvents"
                                />
                            </template>
                        </v-date-time>
                        <jet-input-error :message="form.error('start')" class="mt-2" />
                    </div>
                    <div v-if="!form.full_day">
                        <jet-label for="end" value="End" />
                        <v-date-time id="end" type="datetime" class="mt-1 block w-full" v-model="form.end" ref="end" autocomplete="end" mode="dateTime" is24hr>
                            <template v-slot="{ inputValue, inputEvents }">
                                <input
                                    class="px-2 py-1 border rounded focus:outline-none focus:border-blue-300"
                                    :value="inputValue"
                                    v-on="inputEvents"
                                />
                            </template>
                        </v-date-time>
                        <jet-input-error :message="form.error('end')" class="mt-2" />
                    </div>
                </div>

                <jet-label for="full_day" value="Hele dag" />
                <input id="full_day" type="checkbox" class="mt-1 block" v-model="form.full_day" ref="full_day" autocomplete="full_day" />
                <jet-input-error :message="form.error('full_day')" class="mt-2" />
            </template>
            <template v-else #content>
                <p class="py-2">
                    <strong>Start: </strong>{{form.start}}<br />
                    <strong v-if="form.full_day">{{form.end}}</strong>
                </p>
                <hr />
                <p class="py-2">
                    <strong>Description: </strong>
                    <br />{{form.description}}
                </p>

                <div v-if="form.joinable" class="py-2">
                    <hr />
                    <p><strong>Participants:</strong></p>
                    <ul class="list-disc pl-4">
                        <li v-for="participant of modal.participants">{{participant.name}}</li>
                    </ul>
                </div>
            </template>

            <template #footer>
                <jet-danger-button class="float-left"
                                   @click.native="deleteEvent(modal.event.id)"
                                   v-if="modal.event_by_user === user_id || modal.event_by_user === null
                                    && !modal.new">
                    Delete
                </jet-danger-button>

                <jet-secondary-button @click.native="modal.show = false">
                    Nevermind
                </jet-secondary-button>

                <jet-button class="ml-2"
                            @click.native="saveEvent(modal.new, modal.event.id)"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            v-if="modal.event_by_user === user_id || modal.event_by_user === null">
                    Opslaan
                </jet-button>
                <jet-button class="ml-2"
                            @click.native="joinEvent(modal.event.id)"
                            :class="{ 'opacity-25': joinForm.processing }"
                            :disabled="joinForm.processing"
                            v-else-if="form.joinable">
                    {{ joinOrLeave() }}
                </jet-button>

            </template>
        </jet-dialog-modal>
    </app-layout>
</template>

<script>
import AppLayout from '../../Layouts/AppLayout';
import JetInput from "../../Jetstream/Input";
import JetInputError from "../../Jetstream/InputError";
import JetLabel from "../../Jetstream/Label";
import JetActionMessage from "../../Jetstream/ActionMessage";
import JetButton from "../../Jetstream/Button";
import JetDangerButton from "../../Jetstream/DangerButton";
import FullCalendar from '@fullcalendar/vue';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import JetDialogModal from "../../Jetstream/DialogModal";
import JetSecondaryButton from "../../Jetstream/SecondaryButton";
import VSwatches from 'vue-swatches';
import VDateTime from 'v-calendar/lib/components/date-picker.umd';
import Input from "../../Jetstream/Input";

import FlashMessages from "../../Parts/FlashMessages";

export default {
    name: "Index",
    components: {
        FlashMessages,
        Input,
        FullCalendar,
        JetDangerButton,
        JetActionMessage,
        JetButton,
        AppLayout,
        JetInput,
        JetInputError,
        JetLabel,
        JetDialogModal,
        JetSecondaryButton,
        VSwatches,
        VDateTime
    },
    props: {
        flash: Object,
        tasks: Array,
        searchable_tasks: Object,
        user_id: Number
    },
    data() {
        return {
            calendarOptions: {
                plugins: [dayGridPlugin, interactionPlugin],
                initialView: 'dayGridMonth',
                eventColor: '#6875f5',
                events: this.tasks,
                dateClick: this.dateClick,
                eventClick: this.eventClick,
                nextDayThreshold: '00:00:00'
            },
            joinForm: this.$inertia.form({
                _method: 'PUT'
            }),
            form: this.$inertia.form({
                _method: 'POST',
                color: '#707070',
                title: this.title,
                description: this.description,
                joinable: this.joinable,
                start: this.date,
                end: this.end,
                full_day: this.full_day
            }, {
                resetOnSuccess: true
            }),
            modal: {
                event_by_user: null,
                participants: null,
                show: false,
                new: false,
                event: null
            },
        }
    },
    watch: {
        tasks: {
            handler: function () {
                this.calendarOptions.events = this.tasks;
            },
            deep: true
        }
    },
    methods: {
        joinOrLeave() {
            for (let participant of this.modal.participants) {
                if (participant.id === this.user_id) {
                    return 'Leave';
                }
            }

            return 'Join';
        },
        dateClick(info) {
            this.modal.event_by_user = null;
            this.modal.show = true;
            this.modal.new = true;
            this.form.start = info.dateStr;
            this.modal.event = {
                id: 0
            }
        },
        eventClick(info) {
            // Set form data
            let task = this.searchable_tasks[info.event.id];
            this.form._method = 'PUT';
            this.form.color = task.color;
            this.form.title = task.title;
            this.form.description = task.description;
            this.form.joinable = task.joinable;
            this.form.start = task.start;
            this.form.end = task.end;
            this.form.full_day = task.end === null;
            this.modal.event_by_user = task.user_id;
            this.modal.participants = task.participants;

            // Open model
            this.modal.show = true;
            this.modal.new = false;
            this.modal.event = info.event;
        },
        saveEvent(isNew, id) {
            if (isNew) {
                this.form.post('/tasks', {
                    preserveScroll: true
                })
                .then(() => {
                    if (!this.form.hasErrors()) {
                        this.modal.show = false;
                    }
                });
            }else {
                this.form._method = 'PUT';
                this.form.post('/tasks/'+id, {
                    preserveScroll: true
                })
                .then(() => {
                    if (!this.form.hasErrors()) {
                        this.modal.show = false;
                    }
                });
            }
        },
        joinEvent(task) {
            this.joinForm.post('/tasks/'+task+'/join', {
                preserveScroll: true
            })
            .then(() => {
                if (!this.form.hasErrors()) {
                    this.modal.show = false;
                }
            });
        },
        deleteEvent(task) {
            this.$inertia.delete('/tasks/'+task, {
                preserveScroll: true,
                onSuccess: () => {
                    this.modal.show = false;
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
