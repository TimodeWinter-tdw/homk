<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Debt management
            </h2>
        </template>

        <div v-if="flash !== undefined && flash.message !== undefined" class="alert">
            {{ flash.message }}
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid gap-4 grid-cols-1 md:grid-cols-2">

                    <div class="bg-primary text-white p-4 overflow-hidden shadow-xl rounded-lg">
                        <span class="card-title">Your debt</span>

                        <table class="table-auto w-full" v-if="personal.user_debt !== undefined && personal.user_debt.length > 0">
                            <thead>
                                <tr>
                                    <th class="py-2 text-left">Aan</th>
                                    <th class="py-2 text-left">Omschrijving</th>
                                    <th class="py-2 text-left">Bedrag</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item of personal.user_debt">
                                    <td class="border w-2/5 px-4 py-2">{{item.creator.name}}</td>
                                    <td class="border w-3/5 px-4 py-2">{{item.description}}</td>
                                    <td class="border w-2/5 px-4 py-2">&euro;{{item.amount}}</td>
                                </tr>
                                <tr>
                                    <td class="w-3/5"></td>
                                    <td class="border w-2/5 px-4 py-2">&euro;{{calcTotal(personal.user_debt)}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <p class="mt-10" v-else>You don't have any debt. Nicely done dickhead!</p>

                    </div>

                    <div class="bg-white p-4 overflow-hidden shadow-xl rounded-lg" v-for="user of users">
                        <span class="card-title">{{user.name}}'s debt to you</span>
                        <span class="card-option"><jet-button @click.native="openModal(user)"><i class="fas fa-plus"></i></jet-button></span>

                        <table class="table-auto w-full" v-if="user.user_debt !== undefined && user.user_debt.length > 0">
                            <thead>
                            <tr>
                                <th class="py-2 text-left">Omschrijving</th>
                                <th class="py-2 text-left">Bedrag</th>
                                <th class="py-2"></th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item of user.user_debt">
                                    <td class="border w-3/5 px-4 py-2">{{item.description}}</td>
                                    <td class="border w-2/5 px-4 py-2">&euro;{{item.amount}}</td>
                                    <td class="border w-1/5 px-4 py-2">
                                        <danger-button class="ml-auto" @click.native="deleteItem(item.id, false)"><i class="fas fa-trash"></i>&nbsp;DELETE</danger-button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-3/5"></td>
                                    <td class="border w-2/5 px-4 py-2">&euro;{{calcTotal(user.user_debt)}}</td>
                                    <td class="border w-1/5 px-4 py-2">
                                        <danger-button class="ml-auto" @click.native="deleteItem(0, true)"><i class="fas fa-trash"></i>&nbsp;ALL</danger-button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <p class="mt-10" v-else>{{user.name}} has no debt to you.</p>
                    </div>

                </div>
            </div>

        </div>

        <jet-dialog-modal :show="create.modal" @close="create.modal = false">
            <template #title>
                Create item for {{create.user.name}}
            </template>

            <template #content>

                <div class="mt-4">
                    <jet-label for="amount" value="Amount" />
                    <jet-input id="amount" type="number" step="any" class="mt-1 block w-full" v-model="create_form.amount" ref="amount" autocomplete="amount" />
                    <jet-input-error :message="create_form.error('amount')" class="mt-2" />
                </div>
                <div class="mt-4">
                    <jet-label for="description" value="Description" />
                    <jet-input id="description" type="text" class="mt-1 block w-full" v-model="create_form.description" ref="description" autocomplete="description" />
                    <jet-input-error :message="create_form.error('description')" class="mt-2" />
                </div>
            </template>

            <template #footer>
                <jet-secondary-button @click.native="create.modal = false">
                    Nevermind
                </jet-secondary-button>

                <jet-button class="ml-2" @click.native="createItem()" :class="{ 'opacity-25': create_form.processing }" :disabled="create_form.processing">
                    Opslaan
                </jet-button>
            </template>
        </jet-dialog-modal>

    </app-layout>
</template>

<script>
import JetDangerButton from "../../Jetstream/DangerButton";
import JetActionMessage from "../../Jetstream/ActionMessage";
import JetButton from "../../Jetstream/Button";
import AppLayout from "../../Layouts/AppLayout";
import JetInput from "../../Jetstream/Input";
import JetInputError from "../../Jetstream/InputError";
import JetLabel from "../../Jetstream/Label";
import DangerButton from "../../Jetstream/DangerButton";
import Button from "../../Jetstream/Button";
import JetDialogModal from "../../Jetstream/DialogModal";
import JetSecondaryButton from "../../Jetstream/SecondaryButton";

export default {
    name: "Index",
    components: {
        Button,
        DangerButton,
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
        personal: Object,
        users: Array,
        flash: String
    },
    data() {
        return {
            create: {
                user: {
                    id: null,
                    name: null
                },
                modal: false
            },
            create_form: this.$inertia.form({
                amount: this.amount,
                description: this.description
            }, {
                resetOnSuccess: true
            }),
            delete_form: this.$inertia.form({
                '_method': 'DELETE'
            })
        }
    },
    methods: {
        openModal(user) {
            this.create.user = user;
            this.create.modal = true;
        },
        createItem() {
            this.create_form.post('/debt-management/'+this.create.user.id, {
                preserveScroll: true
            })
            .then(() => {
                if (! this.create_form.hasErrors()) {
                    this.create.modal = false;
                }
            })
        },
        deleteItem(id, all) {
            this.delete_form.post('/debt-management/'+id+'/'+all, {
                preserveScroll: true
            })
        },
        calcTotal(items) {
            let total = 0;
            for (let i = 0; i < items.length; i++) {
                total += items[i].amount;
                if (i === items.length-1) {
                    return total;
                }
            }
        }
    }
}
</script>

<style scoped>

</style>
