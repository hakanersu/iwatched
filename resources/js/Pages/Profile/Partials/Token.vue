<template>
    <jet-form-section @submitted="updatePassword">
        <template #title>
            The Movie DB API
        </template>

        <template #description>
            We need this for fetching movie posters. You can check save checkbox for store images in local storage, subsequent requests will use local storage.
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="token" value="TMDB Token" />
                <jet-input id="token" type="text" class="mt-1 block w-full" v-model="form.token" ref="token" autocomplete="token" />
                <jet-input-error :message="form.errors.token" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <label class="flex items-center">
                    <jet-checkbox :value="form.save" v-model:checked="form.save"/>
                    <span class="ml-2 text-sm text-gray-600">Save images to local storage.</span>
                </label>
            </div>
        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </jet-action-message>

            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
import { defineComponent } from 'vue'
import JetActionMessage from '@/Jetstream/ActionMessage.vue'
import JetButton from '@/Jetstream/Button.vue'
import JetFormSection from '@/Jetstream/FormSection.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetLabel from '@/Jetstream/Label.vue'
import JetCheckbox from '@/Jetstream/Checkbox.vue'

export default defineComponent({
    components: {
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        JetCheckbox,
    },
    props: ['user'],
    data() {
        return {
            form: this.$inertia.form({
                token: this.user.token,
                save: this.user.save_posters,
            }),
        }
    },

    methods: {
        updatePassword() {
            this.form.put(route('token'), {
                errorBag: 'updateToken',
                preserveScroll: true,
                onSuccess: () => {},
                onError: () => {
                    if (this.form.errors.token) {
                        this.form.reset('token')
                        this.$refs.token.focus()
                    }
                }
            })
        },
    },
})
</script>
