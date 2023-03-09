<x-profile :sharedData="$sharedData" doctitle="Who {{ auth()->user()->username }} Follows">
  @include('profile-following-only')
</x-profile>