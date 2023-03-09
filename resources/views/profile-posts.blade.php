<x-profile :sharedData="$sharedData" doctitle="{{ auth()->user()->username }}'s Profile">
  @include('profile-posts-only')
</x-profile>