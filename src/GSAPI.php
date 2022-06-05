<?php
  declare(strict_types=1);

	namespace Fawno\GhostscriptAPI;

	use FFI;
	use FFI\CData;
	use Fawno\GhostscriptAPI\GSAPIException;
	use Fawno\GhostscriptAPI\FFIExtended;

	class GSAPI {
		public const GS_ARG_ENCODING_LOCAL = 0;
    public const GS_ARG_ENCODING_UTF8 = 1;
    public const GS_ARG_ENCODING_UTF16LE = 2;

		protected FFI $gs;
		protected CData $gsapi_revision;
		protected CData $instance;
		protected array $params = [];

		protected const HEADER = <<<EOT
			typedef struct gsapi_revision_s { const char *product; const char *copyright; long revision; long revisiondate; } gsapi_revision_t;

			int gsapi_revision(gsapi_revision_t *pr, int len);
			int gsapi_new_instance(void **pinstance, void *caller_handle);
			void gsapi_delete_instance(void *instance);
			int gsapi_set_stdio(void *instance,
					int (* stdin_fn)(void *caller_handle, char *buf, int len),
					int (* stdout_fn)(void *caller_handle, const char *str, int len),
					int (* stderr_fn)(void *caller_handle, const char *str, int len));
			int gsapi_set_arg_encoding(void *instance, int encoding);
			int gsapi_init_with_args(void *instance, int argc, char **argv);
			int gsapi_run_string_begin(void *instance, int user_errors, int *pexit_code);
			int gsapi_run_string_continue(void *instance, const char *str, unsigned int length, int user_errors, int *pexit_code);
			int gsapi_run_string_end(void *instance, int user_errors, int *pexit_code);
			int gsapi_run_string_with_length(void *instance, const char *str, unsigned int length, int user_errors, int *pexit_code);
			int gsapi_run_string(void *instance, const char *str, int user_errors, int *pexit_code);
			int gsapi_run_file(void *instance, const char *file_name, int user_errors, int *pexit_code);
			int gsapi_exit(void *instance);
		EOT;

		public function __construct(string $lib_path) {
			if (!is_file($lib_path)) {
				throw new GSAPIException(sprintf('% not found', $lib_path));
			}

			$this->params = [
				basename($lib_path),
				'-dSAFER',
				'-dBATCH',
				'-dNOPAUSE',
			];

			$this->gs = FFI::cdef(self::HEADER, $lib_path);

			$this->gsapi_revision = $this->gs->new('gsapi_revision_t');
			if (0 == $this->gs->gsapi_revision(FFI::addr($this->gsapi_revision), FFI::sizeof($this->gsapi_revision))) {
				if ($this->gsapi_revision->revision < 918) {
					throw new GSAPIException('Need at least Ghostscript 9.18');
				}
			} else {
				throw new GSAPIException('Revision structure size is incorrect');
			}

			$this->instance = $this->gs->new('void *');
			if (0 !== $code = $this->gs->gsapi_new_instance(FFI::addr($this->instance), null)) {
				throw new GSAPIException('Error creating new gsapi instance', $code);
			}
		}

		public function set_stdio (object $stdin_fn, object $stdout_fn, object $stderr_fn) : int  {
			return $this->gs->gsapi_set_stdio($this->instance, $stdin_fn, $stdout_fn, $stderr_fn);
		}

		public function set_arg_encoding (int $encoding) {
			if (0 !== $code = $this->gs->gsapi_set_arg_encoding($this->instance, 0)) {
				throw new GSAPIException('Error setting arguments encoding', $code);
			}
		}

		public function run_with_args (array $argv) {
			$params = array_merge($this->params, $argv);
			$argc = count($params);
			$argv = FFIExtended::argsPtr($params);

			if (0 !== $code = $this->gs->gsapi_init_with_args($this->instance, $argc, $argv)) {
				throw new GSAPIException('Error initialising instance with args', $code);
			}

			if (0 !== $code = $this->gs->gsapi_exit($this->instance)) {
				throw new GSAPIException('Error shutdown instance', $code);
			}
		}
	}
