<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Shopping list
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                        <div v-if="flash !== undefined && flash.message !== undefined" class="alert">
                            {{ flash.message }}
                        </div>

                        <FullCalendar :options="calendarOptions"></FullCalendar>
                    </div>
                </div>
            </div>
        </div>


        <jet-dialog-modal :show="modal.show" @close="modal.show = false">
            <template #title>
                Create a new calendar event
            </template>

            <template #content>
                <p>test</p>
            </template>

            <template #footer>
                <jet-secondary-button @click.native="modal.show = false">
                    Nevermind
                </jet-secondary-button>

                <jet-button class="ml-2" @click.native="saveEvent(modal.new, modal.event.id)" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Opslaan
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

export default {
    name: "Index",
    components: {
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
    },
    props: {
        flash: String
    },
    data() {
        return {
            calendarOptions: {
                plugins: [dayGridPlugin, interactionPlugin],
                initialView: 'dayGridMonth',
                eventColor: '#6875f5',
                events: [],
                dateClick: this.dateClick,
                eventClick: this.eventClick
            },
            form: this.$inertia.form({
                title: this.title,
                description: this.description,
                start: this.date,
                end: this.end,
                category: this.category
            }, {
                resetOnSuccess: true
            }),
            modal: {
                show: false,
                new: false,
                event: null
            },
        }
    },
    methods: {
        dateClick(info) {
            this.modal.show = true;
            this.modal.new = true;
        },
        eventClick(info) {
            this.modal.show = true;
            this.modal.new = false;
            this.event = info.event;
        },
        saveEvent(isNew, id) {

        }
    }
}
</script>

<style scoped>

</style>
