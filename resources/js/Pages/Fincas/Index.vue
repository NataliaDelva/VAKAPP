<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DangerButton from "@/Components/DangerButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import SelectInput from "@/Components/SelectInput.vue";
import WarningButton from "@/Components/WarningButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Modal from "@/Components/Modal.vue";
import Pagination from "@/Components/Pagination.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { nextTick, ref } from "vue";
import Swal from "sweetalert2";
import VueTailwindPagination from "@ocrv/vue-tailwind-pagination";

const nombreInput = ref(null);
const modal = ref(false);
const title = ref("");
const operation = ref(1);
const id = ref("");

const props = defineProps({
    fincas: { type: Object },
});
const form = useForm({
    nombre: "",
    direccion: "",
    dimension: "",
    nro_finca: "",
});
const formPage = useForm({});
const onPageClick = (event) => {
    formPage.get(route("fincas.index", { page: event }));
};
const openModal = (op, nombre, direccion, dimension, nro_finca, id_finca) => {
    modal.value = true;
    nextTick(() => nombreInput.value.focus());
    operation.value = op;
    id.value = id_finca;
    if (op == 1) {
        title.value = "Create finca";
    } else {
        title.value = "Edit finca";
        form.nombre = nombre;
        form.direccion = direccion;
        form.dimension = dimension;
        form.nro_finca = nro_finca;
    }
};
const closeModal = () => {
    modal.value = false;
    form.reset();
    clearErrors();
};
const save = () => {
    if (operation.value == 1) {
        form.post(route("fincas.store"), {
            onSuccess: () => {
                ok("Finca created");
            },
        });
    } else {
        form.put(route("fincas.update", id.value), {
            onSuccess: () => {
                ok("Finca updated");
            },
        });
    }
};
const ok = (msj) => {
    form.reset();
    closeModal();
    Swal.fire({ title: msj, icon: "success" });
};
const deleteFinca = (id, name) => {
    const alerta = Swal.mixin({
        buttonsStyling: true,
    });
    alerta
        .fire({
            title: "Are you sure delete " + name + " ?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: '<i class="fa-solid fa-check"></i> Yes,delete',
            cancelButtonText: '<i class="fa-solid fa-ban"></i> Cancel',
        })
        .then((result) => {
            if (result.isConfirmed) {
                form.delete(route("fincas.destroy", id), {
                    onSuccess: () => {
                        ok("Finca deleted");
                    },
                });
            }
        });
};

function clearErrors() {
    form.errors.nombre = "";
    form.errors.direccion = "";
    form.errors.dimension = "";
    form.errors.nro_finca = "";
}
</script>

<template>
    <Head title="Fincas" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Fincas
            </h2>
        </template>

        <div class="bg-white grid v-screen place-items-center">
            <div class="mt-3 mb-3 flex">
                <Search />
            </div>
        </div>

        <div class="py-12">
            <div class="bg-white grid v-screen place-items-center">
                <div class="mt-3 mb-3 flex">
                    <PrimaryButton @click="openModal(1)">
                        <i class="fa-solid fa-plus-circle"></i> Add
                    </PrimaryButton>
                </div>
            </div>
            <div
                class="bg-white grid v-screen place-items-center overflow-x-auto py-3"
            >
                <table class="table-auto border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-2 py-2">Id</th>
                            <th class="px-2 py-2">Nombre</th>
                            <th class="px-2 py-2">Direccion</th>
                            <th class="px-2 py-2">Dimension</th>
                            <th class="px-2 py-2">Número</th>
                            <th class="px-2 py-2"></th>
                            <th class="px-2 py-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(finc, i) in fincas.data" :key="finc.id">
                            <td class="border border-gray-400 px-2 py-2">
                                {{ finc.id }}
                            </td>
                            <td class="border border-gray-400 px-2 py-2">
                                {{ finc.nombre }}
                            </td>
                            <td class="border border-gray-400 px-2 py-2">
                                {{ finc.direccion }}
                            </td>
                            <td class="border border-gray-400 px-2 py-2">
                                {{ finc.dimension }}
                            </td>
                            <td class="border border-gray-400 px-2 py-2">
                                {{ finc.nro_finca }}
                            </td>
                            <td class="border border-gray-400 px-2 py-2">
                                <WarningButton
                                    @click="
                                        openModal(
                                            2,
                                            finc.nombre,
                                            finc.direccion,
                                            finc.dimension,
                                            finc.nro_finca,
                                            finc.id
                                        )
                                    "
                                >
                                    <i class="fa-solid fa-edit"></i>
                                </WarningButton>
                            </td>
                            <td class="border border-gray-400 px-2 py-2">
                                <DangerButton
                                    @click="
                                        deleteFinca(finc.id, finc.nombre)
                                    "
                                >
                                    <i class="fa-solid fa-trash"></i>
                                </DangerButton>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <Pagination :data="fincas" />
            
        </div>

        <!-- MODAL -->
        <Modal :show="modal" @close="closeModal">
            <h2 class="p-3 text-lg font.medium text-hray-900">{{ title }}</h2>
            <div class="p-3 mt-6">
                <InputLabel for="nombre" value="Nombre:"></InputLabel>
                <TextInput
                    id="nombre"
                    ref="nombreInput"
                    v-model="form.nombre"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="Nombre"
                ></TextInput>
                <InputError
                    :message="form.errors.nombre"
                    class="mt-2"
                ></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="direccion" value="Direccion:"></InputLabel>
                <TextInput
                    id="direccion"
                    v-model="form.direccion"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="Direccion"
                ></TextInput>
                <InputError
                    :message="form.errors.direccion"
                    class="mt-2"
                ></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="dimension" value="Dimension:"></InputLabel>
                <TextInput
                    id="dimension"
                    v-model="form.dimension"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="Dimension"
                ></TextInput>
                <InputError
                    :message="form.errors.dimension"
                    class="mt-2"
                ></InputError>
            </div>

            <div class="p-3">
                <InputLabel
                    for="nro_finca"
                    value="Numero de finca:"
                ></InputLabel>
                <TextInput
                    id="nro_finca"
                    v-model="form.nro_finca"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="Numero de finca"
                ></TextInput>
                <InputError
                    :message="form.errors.nro_finca"
                    class="mt-2"
                ></InputError>
            </div>

            <div class="p-3 mt-6">
                <PrimaryButton :disabled="form.processing" @click="save">
                    <i class="fa-solid fa-save"></i> Save
                </PrimaryButton>
            </div>
            <div class="p-3 mt-6 flex justify-end">
                <SecondaryButton
                    class="ml-3"
                    :disabled="form.processing"
                    @click="closeModal"
                >
                    Cancel
                </SecondaryButton>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
