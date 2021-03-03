<template>
    <default-field :errors="errors" :field="field">
        <template slot="field">
            <div class="mb-6" v-if="hasValue">
                <template v-if="shouldShowLoader">
                    <ImageLoader
                            :maxWidth="maxWidth"
                            :src="imageUrl"
                            @missing="value => (missing = value)"
                    />
                </template>

                <template v-if="field.value && !imageUrl">
                    <card
                            class="flex item-center relative border border-lg border-50 overflow-hidden p-4"
                    >
                        <span class="truncate mr-3"> {{ field.value }} </span>

                        <DeleteButton
                                :dusk="field.attribute + '-internal-delete-link'"
                                @click="confirmRemoval"
                                class="ml-auto"
                                v-if="shouldShowRemoveButton"
                        />
                    </card>
                </template>

                <p class="mt-3 flex items-center text-sm" v-if="imageUrl">
                    <DeleteButton
                            :dusk="field.attribute + '-delete-link'"
                            @click="confirmRemoval"
                            v-if="shouldShowRemoveButton"
                    >
                        <span class="class ml-2 mt-1"> {{ __('Delete') }} </span>
                    </DeleteButton>
                </p>

                <portal to="modals">
                    <confirm-upload-removal-modal
                            @close="closeRemoveModal"
                            @confirm="removeFile"
                            v-if="removeModalOpen"
                    />
                </portal>
            </div>

            <span :class="{ 'opacity-75': isReadonly }" class="form-file mr-4">
        <input
                :accept="field.acceptedTypes"
                :disabled="isReadonly || uploading"
                :dusk="field.attribute"
                :id="idAttr"
                @change="fileChange"
                class="form-file-input select-none"
                name="name"
                ref="fileField"
                type="file"
        />
        <label
                :for="labelFor"
                class="form-file-btn btn btn-default btn-primary select-none"
        >
          <span v-if="uploading"
          >{{ __('Uploading') }} ({{ uploadProgress }}%)</span
          >
          <span v-else>{{ __('Choose File') }}</span>
        </label>
      </span>

            <span class="text-gray-50 select-none"> {{ currentLabel }} </span>

            <p class="text-xs mt-2 text-danger" v-if="hasError">{{ firstError }}</p>
        </template>
    </default-field>
</template>
<script>
    import FileField from '@/components/Form/FileField'

    export default {
        mixins: [FileField]
    }
</script>
