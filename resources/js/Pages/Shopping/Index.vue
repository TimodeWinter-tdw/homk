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

                        <form @submit.prevent="save">
                            <div class="grid grid-cols-12 gap-4 mb-4">
                                <div class="col-span-12 lg:col-span-2">
                                    <jet-label for="product" value="Product" />
                                    <jet-input id="product" type="text" class="mt-1 block w-full" v-model="form.product" ref="product" autocomplete="product" />
                                    <jet-input-error :message="form.error('product')" class="mt-2" />
                                </div>
                                <div class="col-span-12 lg:col-span-9">
                                    <jet-label for="description" value="Description" />
                                    <jet-input id="description" type="text" class="mt-1 block w-full" v-model="form.description" ref="description" autocomplete="description" />
                                    <jet-input-error :message="form.error('description')" class="mt-2" />
                                </div>
                                <div class="col-span-12 lg:col-span-1">
                                    <jet-label for="description" value="Save" style="opacity: 0" />
                                    <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                                        Saved.
                                    </jet-action-message>

                                    <jet-button class="mt-1" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click.prevent="save">
                                        Save
                                    </jet-button>
                                </div>
                            </div>
                        </form>

                        <hr />

                        <div v-if="flash !== undefined && flash.message !== undefined" class="alert">
                            {{ flash.message }}
                        </div>

                        <table class="table-auto w-full mt-4">
                            <thead>
                                <tr>
                                    <th class="text-left">Product</th>
                                    <th class="text-left">Description</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item of items">
                                    <td class="text-left">{{item.product}}</td>
                                    <td class="text-left">{{item.description}}</td>
                                    <td class="text-right">
                                        <jet-danger-button class="ml-2" @click.native="deleteItem(item.id)" :class="{ 'opacity-25': deleteForm.processing }" :disabled="deleteForm.processing">
                                            Delete
                                        </jet-danger-button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
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

export default {
    name: "Index",
    components: {
        JetDangerButton,
        JetActionMessage,
        JetButton,
        AppLayout,
        JetInput,
        JetInputError,
        JetLabel,
    },
    props: {
        items: Array,
        flash: String,
    },
    data() {
        return {
            form: this.$inertia.form({
                product: this.product,
                description: this.description,
            }, {
                resetOnSuccess: true
            }),
            deleteForm: this.$inertia.form({
                '_method': 'DELETE'
            })
        }
    },
    methods: {
        save() {
            this.form.post('/shopping/', {
                preserveScroll: true
            });
        },
        deleteItem(id) {
            this.deleteForm.post('/shopping/'+id, {
                preserveScroll: true
            });
        }
    }
}
</script>

<style scoped>

</style>
