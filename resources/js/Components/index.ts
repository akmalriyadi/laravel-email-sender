import { defineAsyncComponent } from 'vue'

const Input = defineAsyncComponent(() => import('./Input.vue'))
const Button = defineAsyncComponent(() => import('./Button.vue'))
const Header = defineAsyncComponent(() => import('./Header.vue'))
const Sidebar = defineAsyncComponent(() => import('./Sidebar.vue'))
const MenuSidebar = defineAsyncComponent(() => import('./MenuSidebar.vue'))
const MenuDropdownSidebar = defineAsyncComponent(() => import('./MenuDropdownSidebar.vue'))
const Card = defineAsyncComponent(() => import('./Card.vue'))
const BasicTable = defineAsyncComponent(() => import('./BasicTable.vue'))
const ContentTable = defineAsyncComponent(() => import('./ContentTable.vue'))
const Select = defineAsyncComponent(() => import('./Select.vue'))
const ShowData = defineAsyncComponent(() => import('./ShowData.vue'))
const ButtonBack = defineAsyncComponent(() => import('./ButtonBack.vue'))
const Tinymce = defineAsyncComponent(() => import('./Tinymce.vue'))
const ImageUpload = defineAsyncComponent(() => import('./ImageUpload.vue'))
const ModalLoading = defineAsyncComponent(() => import('./ModalLoading.vue'))
const ModalPopUp = defineAsyncComponent(() => import('./ModalPopUp.vue'))

export { Input, Button, Header, Sidebar, MenuSidebar, MenuDropdownSidebar, Card, BasicTable, ContentTable, Select, ButtonBack, ShowData, Tinymce, ImageUpload, ModalLoading, ModalPopUp }