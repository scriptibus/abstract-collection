# abstract-collection
Provides an AbstractCollection which can be extended by any specific collection which can be used as typed array.

1. Create your collection class
2. Simply extend Scriptibus\AbstractCollection
3. Implement getClass() with return YourClass::class
4. Override all non-final methods and add typehints
5. Add the splat operator (...) to the parent call in __construct()

See an example in the examples directory
