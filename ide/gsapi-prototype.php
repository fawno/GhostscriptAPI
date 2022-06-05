<?php
	use FFI\CData;

	final class FFI {
		/**
		 * Get version numbers and strings.
		 *
		 * int gsapi_revision(gsapi_revision_t *pr, int len);
		 *
		 * This is safe to call at any time.
		 * You should call this first to make sure that the correct version
		 * of the Ghostscript is being used.
		 * pr is a pointer to a revision structure.
		 * len is the size of this structure in bytes.
		 * Returns 0 if OK, or if len too small (additional parameters
		 * have been added to the structure) it will return the required
		 * size of the structure.
		 *
		 * @param CData $gsapi_revision_t gsapi_revision_t *pr
		 * @param int $len int len
		 * @return int
		 */
		public function gsapi_revision(CData &$gsapi_revision_t, int $len) : int { return 0; }

		/**
		 * Create a new instance of Ghostscript.
		 *
		 * int gsapi_new_instance(void **pinstance, void *caller_handle);
		 *
		 * **WARNING WARNING WARNING WARNING WARNING WARNING WARNING WARNING**
		 *
		 *  On non-threading capable platforms, Ghostscript supports only
		 *  one instance. The current implementation uses a global static
		 *  instance counter to make sure that only a single instance is
		 *  used. If you try to create two instances, the second attempt
		 *  will return < 0 and set pinstance to NULL.
		 *
		 * **WARNING WARNING WARNING WARNING WARNING WARNING WARNING WARNING**
		 *
 		 * This instance is passed to most other API functions.
 		 * The caller_handle will be provided to callback functions.
 		 *
		 * @param CData $pinstance void **pinstance
		 * @param null|CData $caller_handle void *caller_handle
		 * @return int
		 */
		public function gsapi_new_instance(CData &$pinstance, ?CData &$caller_handle) : int { return 0; }

		/**
		 * Destroy an instance of Ghostscript
		 *
		 * void gsapi_delete_instance(void *instance);
		 *
		 * **WARNING WARNING WARNING WARNING WARNING WARNING WARNING WARNING**
		 *
		 *  On non-threading capable platforms, Ghostscript supports only
		 *  one instance. The current implementation uses a global static
		 *  instance counter to make sure that only a single instance is
		 *  used.
		 *
		 * **WARNING WARNING WARNING WARNING WARNING WARNING WARNING WARNING**
		 *
		 * Before you call this, Ghostscript must have finished.
		 * If Ghostscript has been initialised, you must call gsapi_exit()
		 * before gsapi_delete_instance.
		 *
		 * @param CData $instance void *instance
		 * @return void
		 */
		public function gsapi_delete_instance(CData &$instance) : void {}

		/**
		 * Set the callback functions for stdio
		 *
		 * int gsapi_set_stdio(void *instance,
		 *  int (* stdin_fn)(void *caller_handle, char *buf, int len),
		 *  int (* stdout_fn)(void *caller_handle, const char *str, int len),
		 *  int (* stderr_fn)(void *caller_handle, const char *str, int len));
		 *
		 * The stdin callback function should return the number of
		 * characters read, 0 for EOF, or -1 for error.
		 * The stdout and stderr callback functions should return
		 * the number of characters written.
		 * If a callback address is NULL, the real stdio will be used.
		 *
		 * @param CData $instance void *instance
		 * @param object $stdin_fn function ($caller_handle, string $buffer, int $len) {}
		 * @param object $stdout_fn function ($caller_handle, string $buffer, int $len) {}
		 * @param object $stderr_fn function ($caller_handle, string $buffer, int $len) {}
		 * @return int
		 */
		public function gsapi_set_stdio(CData &$instance, object $stdin_fn, object $stdout_fn, object $stderr_fn) : int { return 0; }

		/**
		 * Set the encoding used for the args.
		 *
		 * int gsapi_set_arg_encoding(void *instance, int encoding);
		 *
		 * Set the encoding used for the args. By default we assume
		 * 'local' encoding. For windows this equates to whatever the current
		 * codepage is. For linux this is utf8.
		 *
		 * Use of this API (gsapi) with 'local' encodings (and hence without calling
		 * this function) is now deprecated!
		 *
		 * @param CData $instance void *instance
		 * @param int $encoding int encoding
		 * @return int
		 */
		public function gsapi_set_arg_encoding(CData &$instance, int $encoding) : int { return 0; }


		/**
		 * Initialise the interpreter.
		 *
		 * int gsapi_init_with_args(void *instance, int argc, char **argv);
		 *
		 * This calls gs_main_init_with_args() in imainarg.c
		 * 1. If quit or EOF occur during gsapi_init_with_args(),
		 *    the return value will be gs_error_Quit.  This is not an error.
		 *    You must call gsapi_exit() and must not call any other
		 *    gsapi_XXX functions.
		 * 2. If usage info should be displayed, the return value will be gs_error_Info
		 *    which is not an error.  Do not call gsapi_exit().
		 * 3. Under normal conditions this returns 0.  You would then
		 *    call one or more gsapi_run_*() functions and then finish
		 *    with gsapi_exit().
		 *
		 * @param CData $instance void *instance
		 * @param int $argc int argc
		 * @param CData $argv char **argv
		 * @return int
		 */
		public function gsapi_init_with_args(CData &$instance, int $argc, CData &$argv) : int { return 0; }

		/**
		 * Exit the interpreter.
		 *
		 * int gsapi_exit(void *instance);
		 *
		 * This must be called on shutdown if gsapi_init_with_args()
		 * has been called, and just before gsapi_delete_instance().
		 *
		 * @param CData $instance void *instance
		 * @return int
		 */
		public function gsapi_exit(CData &$instance) : int { return 0; }

	}