// Import our custom NuxtUI-style components
import UButton from '@/Components/UI/UButton.vue'
import UInput from '@/Components/UI/UInput.vue'
import UCard from '@/Components/UI/UCard.vue'
import UFormGroup from '@/Components/UI/UFormGroup.vue'
import UAlert from '@/Components/UI/UAlert.vue'
import UContainer from '@/Components/UI/UContainer.vue'
import UMain from '@/Components/UI/UMain.vue'
import UHeader from '@/Components/UI/UHeader.vue'
import UCheckbox from '@/Components/UI/UCheckbox.vue'
import UIcon from '@/Components/UI/UIcon.vue'

export default {
  install(app) {
    // Register NuxtUI-style components globally
    app.component('UButton', UButton)
    app.component('UInput', UInput)
    app.component('UCard', UCard)
    app.component('UFormGroup', UFormGroup)
    app.component('UAlert', UAlert)
    app.component('UContainer', UContainer)
    app.component('UMain', UMain)
    app.component('UHeader', UHeader)
    app.component('UCheckbox', UCheckbox)
    app.component('UIcon', UIcon)
  }
}
