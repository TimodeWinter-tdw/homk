<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Debt management
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid gap-4 grid-cols-1 md:grid-cols-2">

                    <div class="bg-primary text-white p-4 overflow-hidden shadow-xl rounded-lg">
                        <h4 class="card-title">Your debt</h4>

                        <table class="table-auto w-full">
                            <thead>
                                <tr>
                                    <th class="py-2 text-left">Aan</th>
                                    <th class="py-2 text-left">Bedrag</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border w-3/5 px-4 py-2">Martijn</td>
                                    <td class="border w-2/5 px-4 py-2">&euro;2,00</td>
                                </tr>
                                <tr>
                                    <td class="w-3/5"></td>
                                    <td class="border w-2/5 px-4 py-2">total</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                    <div class="bg-white p-4 overflow-hidden shadow-xl rounded-lg">
                        <h4 class="card-title">Martijn's debt to you</h4>

                        <table class="table-auto w-full">
                            <thead>
                            <tr>
                                <th class="py-2 text-left">Aan</th>
                                <th class="py-2 text-left">Bedrag</th>
                                <th class="py-2"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="border w-3/5 px-4 py-2">Martijn</td>
                                <td class="border w-2/5 px-4 py-2">&euro;2,00</td>
                                <td class="border w-1/5 px-4 py-2">
                                    <danger-button class="ml-auto"><i class="fas fa-trash"></i>&nbsp;DELETE</danger-button>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-3/5"></td>
                                <td class="border w-2/5 px-4 py-2">total</td>
                                <td class="border w-1/5 px-4 py-2">
                                    <danger-button class="ml-auto"><i class="fas fa-trash"></i>&nbsp;ALL</danger-button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="bg-white p-4 overflow-hidden shadow-xl rounded-lg">
                        <p>test</p>
                    </div>

                </div>
            </div>


<!--            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">-->
<!--                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">-->
<!--                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">-->

<!--                        <p>test</p>-->

<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
        </div>
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

export default {
    name: "Index",
    components: {
        DangerButton,
        JetDangerButton,
        JetActionMessage,
        JetButton,
        AppLayout,
        JetInput,
        JetInputError,
        JetLabel,
    },
    props: {
        items: Array
    }
}
</script>

<style scoped>

</style>
