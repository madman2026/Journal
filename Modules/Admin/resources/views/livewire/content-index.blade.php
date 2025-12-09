<div class="space-y-10">
    {{-- Activities --}}
    <x-content-table
        type="activities"
        :items="$activities"
        title="رویداد ها"
        :showFiles="true"
        editRoute="activity.edit"
        viewRoute="activity.show"
        showBody="true"
        showImage="false"
/>

    {{-- Tips --}}
    <x-content-table
        type="tips"
        :items="$tips"
        title="نکات"
        editRoute="tip.edit"
        viewRoute="tip.show"
        showBody="true"
        showImage="false"
/>

    {{-- Magazines --}}
    <x-content-table
        :items="$magazines"
        type="magazines"
        title="مجلات"
        :showFiles="true"
        editRoute="magazine.edit"
        viewRoute="magazine.show"
        showBody="true"
        showImage="true"
/>

    {{-- Recommends --}}
    <x-content-table
        :items="$recommends"
        :showFiles="true"
        title="پیشنهادها"
        type="recommends"
/>

</div>
