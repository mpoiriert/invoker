invoker
=======

[![Build Status](https://api.travis-ci.org/mpoiriert/invoker.png?branch=master)](http://travis-ci.org/mpoiriert/invoker)

Service to execute a callable by passing it's parameter by name or type.

You can also register a Parameter value provider so you can provider parameter value at run time. The system
does register a DefaultParameterValue in it's core with a priority of 0. This will set the default value from the
the ReflectionParameter if any. If you want to be process prior to this you must register with -1 as a priority.
If not provider are able to provide a value a UnableToMatchParameterException will occur.
